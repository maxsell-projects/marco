<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // 1. Lista Geral com Filtros
    public function index(Request $request)
    {
        $query = User::query();

        // REGRA DE SEGURANÇA: Se for DEV, só vê seus próprios clientes
        if (Auth::user()->isDev()) {
            $query->where('parent_id', Auth::id());
        }

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
        // Apenas Admins podem ver a visão geral de todos os Devs
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Acesso restrito a administradores.');
        }

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

    // 3. Formulário de Criação (NOVO)
    public function create()
    {
        return view('panel.users.create');
    }

    // 4. Salvar Novo Usuário (NOVO)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'sometimes|in:admin,dev,client', // Dev não envia role, Admin sim
        ]);

        // Lógica de Hierarquia
        if (Auth::user()->isDev()) {
            // Se quem cria é DEV, o novo user OBRIGATORIAMENTE é Client e filho dele
            $role = 'client';
            $parentId = Auth::id();
        } else {
            // Se é Admin, ele escolhe a role. Se não escolher, assume client. Parent é null (root)
            $role = $request->role ?? 'client';
            $parentId = null; 
        }

        // Gera senha provisória de 8 dígitos
        $tempPassword = Str::random(8); 

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($tempPassword),
            'role' => $role,
            'parent_id' => $parentId,
            'is_active' => true, // Criado manual já nasce ativo
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário cadastrado com sucesso!')
            ->with('temp_password', $tempPassword); // Enviamos a senha para mostrar no alerta
    }
}