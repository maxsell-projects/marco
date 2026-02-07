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

    // 2. Visão Hierárquica (Apenas para Admins)
    public function devs()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Acesso restrito a administradores.');
        }

        $devs = User::where('role', 'dev')
            ->with(['team' => function($q) { // Usando o nome do relacionamento que definimos no Model
                $q->latest();
            }])
            ->withCount('team')
            ->latest()
            ->paginate(10);

        return view('panel.users.devs', compact('devs'));
    }

    // 3. Formulário de Criação
    public function create()
    {
        return view('panel.users.create');
    }

    // 4. Salvar Novo Usuário
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'role' => 'sometimes|in:admin,dev,client', 
        ]);

        // Lógica de Hierarquia Blindada
        if (Auth::user()->isDev()) {
            // Se quem cria é DEV, o novo user OBRIGATORIAMENTE é Client e filho dele
            $role = 'client';
            $parentId = Auth::id();
        } else {
            // Se é Admin, ele escolhe a role.
            $role = $request->role ?? 'client';
            $parentId = null; 
        }

        // Gera senha provisória de 8 dígitos
        $tempPassword = Str::random(8); 

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($tempPassword),
            'role' => $role,
            'parent_id' => $parentId,
            'is_active' => true, 
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário cadastrado com sucesso!')
            ->with('temp_password', $tempPassword); 
    }

    // 5. Exclusão (Segura)
    public function destroy(User $user)
    {
        // Trava: Dev só deleta quem é dele. Admin deleta qualquer um menos ele mesmo.
        if (Auth::user()->isDev() && $user->parent_id !== Auth::id()) {
            abort(403);
        }

        if (Auth::id() === $user->id) {
            return back()->with('error', 'Você não pode excluir sua própria conta.');
        }

        $user->delete();

        return back()->with('success', 'Usuário removido com sucesso.');
    }
}