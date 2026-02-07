<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\PropertyService;
use App\Http\Requests\StorePropertyRequest; // <--- Importante: Cria este arquivo se não criou!
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
        $properties = Property::where('status', 'published')
            ->where('visibility', 'public')
            ->where('is_featured', true) // Opcional: só destaques na home?
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

        // Filtros adicionais (Exemplo)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $properties = $query->latest()->paginate(12);

        return view('properties.index', compact('properties'));
    }

    public function show($id) 
    {
        $property = Property::with(['images', 'owner'])
            ->where(function($q) use ($id) {
                $q->where('id', $id)->orWhere('slug', $id);
            })
            ->firstOrFail();

        // Lógica de Permissão (Mantida igual ao seu original)
        if ($property->visibility === 'public' && $property->status === 'published') {
            return view('properties.show', compact('property'));
        }

        if (!Auth::check()) {
            abort(403, 'Acesso restrito. Faça login.');
        }

        $user = Auth::user();

        if ($user->isAdmin() || $user->id === $property->user_id) {
            return view('properties.show', compact('property'));
        }

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

    public function index()
    {
        $query = Property::query();

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

    // AQUI ESTÁ A CORREÇÃO PRINCIPAL
    public function store(StorePropertyRequest $request) 
    {
        // 1. Pega os dados validados (incluindo arquivos)
        $data = $request->validated();

        // 2. Chama o Service
        $this->service->createProperty($data, Auth::user());

        // 3. Feedback
        $msg = (Auth::user()->isDev() && ($data['status'] ?? '') === 'pending') 
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

        // Regra: Dev editou -> volta para pendente
        if (Auth::user()->isDev()) {
            $data['status'] = 'pending';
            $data['approved_at'] = null;
        }

        $this->service->updateProperty($property, $data);

        return redirect()->route('admin.properties.index')->with('success', 'Imóvel atualizado.');
    }

    public function destroy(Property $property)
    {
        if (Auth::user()->id !== $property->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        // Remover Imagens do disco antes de deletar? 
        // Se configurou 'cascade' no banco e Model Events, pode ser automático.
        // Por segurança, o Service poderia ter um método deleteProperty para limpar arquivos.
        
        $property->delete();

        return redirect()->route('admin.properties.index')->with('success', 'Imóvel removido.');
    }
}