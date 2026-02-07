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

    // --- ÁREA PÚBLICA ---

    public function home()
    {
        $properties = Property::visibleTo(Auth::user())
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('properties'));
    }

    public function publicIndex(Request $request)
    {
        $query = Property::visibleTo(Auth::user());

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
        }

        $properties = $query->latest()->paginate(12);

        return view('properties.index', compact('properties'));
    }

    public function show($id) 
    {
        $property = Property::visibleTo(Auth::user())
            ->with(['images', 'owner'])
            ->where(function($q) use ($id) {
                $q->where('id', $id)->orWhere('slug', $id);
            })
            ->firstOrFail();

        return view('properties.show', compact('property'));
    }

    // --- ÁREA DO CLIENTE ---

    public function myAccess()
    {
        $user = Auth::user();

        // Lista apenas imóveis onde o cliente tem permissão explícita na tabela pivô
        $properties = Property::whereHas('authorizedUsers', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->latest()->paginate(12);

        // Reutilizamos a view pública de listagem, ou crie uma 'panel.client.exclusive' se quiser algo diferente
        return view('properties.index', compact('properties'));
    }

    // --- ÁREA DE GESTÃO (ADMIN / DEV) ---

    public function index()
    {
        $properties = Property::visibleTo(Auth::user())
            ->latest()
            ->paginate(15);

        // CORREÇÃO: Mudamos de admin.properties.index para panel.properties.index
        return view('panel.properties.index', compact('properties'));
    }

    public function create()
    {
        // CORREÇÃO: Mudamos de admin.properties.create para panel.properties.create
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

        $this->service->createProperty($validated, Auth::user());

        return redirect()->route('admin.properties.index')
            ->with('success', 'Imóvel criado com sucesso.');
    }

    public function edit(Property $property)
    {
        if (Auth::user()->cannot('update', $property) && !Auth::user()->isAdmin()) {
             if ($property->user_id !== Auth::id()) {
                abort(403);
             }
        }

        // CORREÇÃO: Mudamos de admin.properties.edit para panel.properties.edit
        return view('panel.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
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

        $this->service->updateProperty($property, $validated);

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