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
    public function index(Request $request)
    {
        $query = User::query();

        if (Auth::user()->isDev()) {
            $query->where('parent_id', Auth::id());
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

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

    public function devs()
    {
        // CORREÇÃO: Permitir ADMIN e DEV
        if (!Auth::user()->isAdmin() && !Auth::user()->isDev()) {
            abort(403, 'Acesso restrito.');
        }

        // Se for Admin, vê todos os Devs. Se for Dev, vê apenas a si mesmo ou sua equipe (dependendo da regra de negócio, aqui mantive lista de Devs geral para Admin, ou ajustado para o contexto)
        // Se a intenção é "Minha Equipe" (clientes do Dev), o método index já cobre.
        // Se a intenção é ver "Outros Devs", mantemos restrito a Admin. 
        // ASSUMINDO QUE "Minha Equipe" refere-se à visão hierárquica:
        
        if (Auth::user()->isDev()) {
             // Se for Dev acessando /equipe, redireciona para seus clientes ou mostra apenas seus dados
             // Ajuste conforme necessidade exata. Por hora, vou liberar visualização mas filtrar se não for admin.
             $devs = User::where('id', Auth::id())->withCount('team')->paginate(10);
        } else {
             $devs = User::where('role', 'dev')
                ->with(['team' => function($q) {
                    $q->latest();
                }])
                ->withCount('team')
                ->latest()
                ->paginate(10);
        }

        return view('panel.users.devs', compact('devs'));
    }

    public function create()
    {
        return view('panel.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'role' => 'sometimes|in:admin,dev,client', 
        ]);

        if (Auth::user()->isDev()) {
            $role = 'client';
            $parentId = Auth::id();
        } else {
            $role = $request->role ?? 'client';
            $parentId = null; 
        }

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

    // --- NOVOS MÉTODOS ADICIONADOS ---

    public function edit(User $user)
    {
        // Trava de Segurança
        if (Auth::user()->isDev() && $user->parent_id !== Auth::id()) {
            abort(403);
        }

        return view('panel.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Trava de Segurança
        if (Auth::user()->isDev() && $user->parent_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone_number' => 'nullable|string|max:20',
            'role' => 'sometimes|in:admin,dev,client',
        ]);

        // Proteção para não mudar role se for Dev editando
        if (Auth::user()->isDev()) {
            $role = $user->role; // Mantém a role original
        } else {
            $role = $request->role ?? $user->role;
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'role' => $role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
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