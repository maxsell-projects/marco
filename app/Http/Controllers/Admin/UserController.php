<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 1. Lista Geral com Filtros
    public function index(Request $request)
    {
        $query = User::query();

        // Filtro por Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filtro de Busca (Nome ou Email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('panel.users.index', compact('users'));
    }

    // 2. Visão Hierárquica (Devs e seus Clientes)
    public function devs()
    {
        // Busca apenas DEVs e já traz seus clientes junto (Eager Loading)
        $devs = User::where('role', 'dev')
            ->with(['clients' => function($q) {
                $q->latest(); // Ordena os clientes do dev
            }])
            ->withCount('clients') // Conta quantos clientes cada um tem
            ->latest()
            ->paginate(10);

        return view('panel.users.devs', compact('devs'));
    }
}