<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccessRequestController extends Controller
{
    /**
     * Lista todas as solicitações pendentes.
     * Apenas Admin tem acesso.
     */
    public function index()
    {
        // TRAVA DE SEGURANÇA: Apenas Admin acessa
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Acesso restrito a administradores.');
        }

        // Busca usuários inativos (pendentes) que NÃO sejam admins
        $requests = User::where('is_active', false)
            ->where('role', '!=', 'admin')
            ->latest()
            ->paginate(10);

        return view('panel.requests.index', compact('requests'));
    }

    /**
     * Mostra detalhes da solicitação (doc + mensagem).
     */
    public function show(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('panel.requests.show', compact('user'));
    }

    /**
     * Aprova o usuário, gera senha e ativa.
     */
    public function approve(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        // 1. Gerar senha provisória
        $tempPassword = Str::random(10); // Ex: aB3dE9fG2h

        // 2. Ativar usuário
        $user->update([
            'is_active' => true,
            'password' => Hash::make($tempPassword),
            'email_verified_at' => now(),
        ]);

        // 3. (Futuro) Disparar E-mail de Boas-vindas
        // Mail::to($user)->send(new AccountApproved($tempPassword));

        // 4. Retornar com a senha para o Admin ver na tela
        return redirect()->route('admin.requests.index')
            ->with('success', 'Usuário aprovado com sucesso!')
            ->with('temp_password', $tempPassword) // Enviamos a senha para a view (via session)
            ->with('approved_user', $user->name);
    }

    /**
     * Rejeita e exclui os dados.
     */
    public function reject(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        // Excluir documento físico se existir
        if ($user->document_path) {
            Storage::disk('public')->delete($user->document_path);
        }

        // Exclui o registro do banco
        $user->delete();

        return redirect()->route('admin.requests.index')
            ->with('success', 'Solicitação rejeitada e dados removidos.');
    }
}