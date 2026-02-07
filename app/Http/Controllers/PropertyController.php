<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\PropertyService;
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
        // Na Home, mostra APENAS o que está 100% público e aprovado
        $properties = Property::where('status', 'published')
            ->where('visibility', 'public')
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('properties'));
    }

    public function publicIndex(Request $request)
    {
        // Busca apenas PUBLICADOS e PÚBLICOS
        $query = Property::where('status', 'published')
            ->where('visibility', 'public');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }

        $properties = $query->latest()->paginate(12);

        return view('properties.index', compact('properties'));
    }

    public function show($id) 
    {
        // Tenta achar o imóvel (por ID ou Slug)
        $property = Property::with(['images', 'owner'])
            ->where(function($q) use ($id) {
                $q->where('id', $id)->orWhere('slug', $id);
            })
            ->firstOrFail();

        // BLINDAGEM DE ACESSO
        // 1. Se for público e publicado -> Libera geral
        if ($property->visibility === 'public' && $property->status === 'published') {
            return view('properties.show', compact('property'));
        }

        // 2. Se não for público, usuário tem que estar logado
        if (!Auth::check()) {
            abort(403, 'Acesso restrito. Faça login.');
        }

        $user = Auth::user();

        // 3. Admin e Dono veem tudo (mesmo rascunho/pendente)
        if ($user->isAdmin() || $user->id === $property->user_id) {
            return view('properties.show', compact('property'));
        }

        // 4. Se for Off-Market/Privado, verifica se tem permissão explícita
        if ($property->authorizedUsers->contains($user->id)) {
            return view('properties.show', compact('property'));
        }

        // Se chegou aqui, não tem acesso
        abort(403, 'Você não tem permissão para ver este imóvel.');
    }

    // --- ÁREA DO CLIENTE (Minha Conta) ---

    public function myAccess()
    {
        $user = Auth::user();

        // Lista imóveis onde o cliente tem permissão EXPLÍCITA (Off-Market)
        $properties = Property::whereHas('authorizedUsers', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->latest()->paginate(12);

        return view('properties.index', compact('properties'));
    }

    // --- ÁREA DE GESTÃO (Painel Admin / Dev) ---

    public function index()
    {
        $query = Property::query();

        // REGRA DE OURO: Dev só vê os SEUS imóveis. Admin vê todos.
        if (Auth::user()->isDev()) {
            $query->where('user_id', Auth::id());
        }

        $properties = $query->latest()->paginate(15);

        return view('panel.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('panel.properties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'area' => 'nullable|numeric',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'garage' => 'nullable|integer',
            'visibility' => 'required|in:public,off_market,private',
            'status' => 'sometimes|string'
        ]);

        $data = $validated;
        
        // FORÇA O DONO A SER QUEM ESTÁ LOGADO
        $data['user_id'] = Auth::id();

        // TRAVA DE SEGURANÇA: Status
        if (Auth::user()->isDev()) {
            // Se for Dev, só pode ser 'draft' ou 'pending'. NUNCA 'published'.
            $data['status'] = ($request->status === 'draft') ? 'draft' : 'pending';
        } else {
            // Admin manda o que quiser (default published)
            $data['status'] = $request->status ?? 'published';
        }

        // Passa os dados para o Service
        // ATENÇÃO: Verifique se seu PropertyService aceita (array $data, User $user) ou apenas ($data)
        // Vou assumir que ele aceita array direto ou você ajusta lá.
        // Se o createProperty pede User como 2º parametro, mantenha Auth::user()
        $this->service->createProperty($data, Auth::user());

        $msg = (Auth::user()->isDev() && $data['status'] === 'pending') 
            ? 'Imóvel enviado para aprovação do Admin!' 
            : 'Imóvel criado com sucesso.';

        return redirect()->route('admin.properties.index')
            ->with('success', $msg);
    }

    public function edit(Property $property)
    {
        // Segurança: Só dono ou Admin mexe
        if (Auth::user()->id !== $property->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('panel.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        // Segurança: Só dono ou Admin mexe
        if (Auth::user()->id !== $property->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'area' => 'nullable|numeric',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'garage' => 'nullable|integer',
            'visibility' => 'required|in:public,off_market,private',
            'status' => 'sometimes|string'
        ]);

        $data = $validated;

        // TRAVA DE SEGURANÇA: Se Dev editar algo publicado, volta para aprovação?
        // Política Comum: Sim. Mexeu = Pendente.
        if (Auth::user()->isDev()) {
            $data['status'] = ($request->status === 'draft') ? 'draft' : 'pending';
        }
        // Se for Admin, ele mantém o status que veio no request ou o que já estava

        $this->service->updateProperty($property, $data);

        return redirect()->route('admin.properties.index')
            ->with('success', 'Imóvel atualizado.');
    }

    public function destroy(Property $property)
    {
        if (Auth::user()->id !== $property->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $property->delete();

        return redirect()->route('admin.properties.index')
            ->with('success', 'Imóvel removido.');
    }
}