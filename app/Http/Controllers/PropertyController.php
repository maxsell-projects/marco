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

    public function home()
    {
        $properties = Property::where('status', 'published')
            ->where('visibility', 'public')
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

        if ($user->authorizedProperties->contains($property->id)) {
            return view('properties.show', compact('property'));
        }

        abort(403, 'Você não tem permissão para ver este imóvel.');
    }

    public function myAccess()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $properties = $user->authorizedProperties()
            ->latest()
            ->paginate(12);

        return view('client.properties.exclusive', compact('properties'));
    }

    public function index(Request $request)
    {
        $query = Property::query();

        if (Auth::user()->isDev()) {
            $query->where('user_id', Auth::id());
        }

        $filter = $request->get('filter', 'all');
        
        if ($filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($filter === 'published') {
            $query->where('status', 'published');
        } elseif ($filter === 'draft') {
            $query->where('status', 'draft');
        }

        $properties = $query->with('owner')->latest()->paginate(15);

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

        $property->update([
            'status' => 'draft',
            'approved_at' => null
        ]);

        return back()->with('success', 'Imóvel rejeitado e movido para Rascunhos.');
    }
}