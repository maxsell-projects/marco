<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\PropertyService;
use App\Http\Requests\StorePropertyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    protected PropertyService $service;

    public function __construct(PropertyService $service)
    {
        $this->service = $service;
    }

    // --- ÁREA PÚBLICA (Site) ---

    public function home()
    {
        // Na Home, mostra APENAS o que está publicado e público
        // Removido o 'is_featured' obrigatório para não esconder imóveis normais
        $properties = Property::where('status', 'published')
            ->where('visibility', 'public')
            // ->where('is_featured', true) // Opcional: descomente se quiser apenas destaques
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('properties'));
    }

    public function publicIndex(Request $request)
    {
        $query = Property::where('status', 'published')
            ->where('visibility', 'public');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }

        // Filtros adicionais
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }
        
        // Ordenação
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_high': $query->orderBy('price', 'desc'); break;
                case 'price_low': $query->orderBy('price', 'asc'); break;
                default: $query->latest(); break;
            }
        } else {
            $query->latest();
        }

        $properties = $query->paginate(12);

        return view('properties.index', compact('properties'));
    }

    public function show($id) 
    {
        $property = Property::with(['images', 'owner'])
            ->where(function($q) use ($id) {
                $q->where('id', $id)->orWhere('slug', $id);
            })
            ->firstOrFail();

        // 1. Público e Publicado -> Acesso Livre
        if ($property->visibility === 'public' && $property->status === 'published') {
            return view('properties.show', compact('property'));
        }

        // 2. Bloqueio para não logados (se não for público)
        if (!Auth::check()) {
            abort(403, 'Acesso restrito. Faça login.');
        }

        $user = Auth::user();

        // 3. Admin e Dono (Dev) veem tudo
        if ($user->isAdmin() || $user->id === $property->user_id) {
            return view('properties.show', compact('property'));
        }

        // 4. Cliente com permissão explícita (Off-Market)
        if ($property->authorizedUsers->contains($user->id)) {
            return view('properties.show', compact('property'));
        }

        abort(403, 'Você não tem permissão para ver este imóvel.');
    }

    // --- ÁREA DO CLIENTE ---

    public function myAccess()
    {
        $user = Auth::user();
        $properties = Property::whereHas('authorizedUsers', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->latest()->paginate(12);

        return view('properties.index', compact('properties'));
    }

    // --- PAINEL GESTÃO (Admin / Dev) ---

    public function index(Request $request)
    {
        $query = Property::query();

        // 1. Regra de Visibilidade (Dev vê apenas os seus)
        if (Auth::user()->isDev()) {
            $query->where('user_id', Auth::id());
        }

        // 2. Filtro por Status (Abas)
        $filter = $request->get('filter', 'all');
        
        if ($filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($filter === 'published') {
            $query->where('status', 'published');
        } elseif ($filter === 'draft') {
            $query->where('status', 'draft');
        }

        $properties = $query->with('owner')->latest()->paginate(15);

        // 3. Contadores para as Abas
        $isDev = Auth::user()->isDev();
        $userId = Auth::id();

        $counts = [
            'all' => $isDev ? Property::where('user_id', $userId)->count() : Property::count(),
            'pending' => $isDev ? Property::where('user_id', $userId)->where('status', 'pending')->count() : Property::where('status', 'pending')->count(),
            'published' => $isDev ? Property::where('user_id', $userId)->where('status', 'published')->count() : Property::where('status', 'published')->count(),
        ];

        return view('panel.properties.index', compact('properties', 'counts', 'filter'));
    }

    public function create()
    {
        return view('panel.properties.create');
    }

    public function store(StorePropertyRequest $request) 
    {
        $data = $request->validated();

        // O Service já lida com o upload e status inicial (Dev = Pending)
        $this->service->createProperty($data, Auth::user());

        $msg = (Auth::user()->isDev() && ($data['status'] ?? '') !== 'draft') 
            ? 'Imóvel enviado para aprovação do Admin!' 
            : 'Imóvel criado com sucesso.';

        return redirect()->route('admin.properties.index')->with('success', $msg);
    }

    public function edit(Property $property)
    {
        if (Auth::user()->id !== $property->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('panel.properties.edit', compact('property'));
    }

    public function update(StorePropertyRequest $request, Property $property)
    {
        if (Auth::user()->id !== $property->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $data = $request->validated();

        // Regra de Ouro: Se Dev editar algo, volta para aprovação (exceto se for rascunho)
        if (Auth::user()->isDev()) {
            $data['status'] = ($request->status === 'draft') ? 'draft' : 'pending';
            $data['approved_at'] = null;
        }

        $this->service->updateProperty($property, $data);

        $msg = (Auth::user()->isDev() && $data['status'] === 'pending') 
            ? 'Alterações enviadas para aprovação.' 
            : 'Imóvel atualizado com sucesso.';

        return redirect()->route('admin.properties.index')->with('success', $msg);
    }

    public function destroy(Property $property)
    {
        if (Auth::user()->id !== $property->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $property->delete();

        return redirect()->route('admin.properties.index')->with('success', 'Imóvel removido.');
    }

    // --- AÇÕES ADMINISTRATIVAS (Apenas Admin) ---

    public function approve(Property $property)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Ação não autorizada.');
        }

        $property->update([
            'status' => 'published',
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Imóvel aprovado e publicado!');
    }

    public function reject(Property $property)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Ação não autorizada.');
        }

        // Rejeitar move para Rascunho para o Dev corrigir
        $property->update([
            'status' => 'draft',
            'approved_at' => null
        ]);

        return back()->with('success', 'Imóvel rejeitado e movido para Rascunhos.');
    }
}