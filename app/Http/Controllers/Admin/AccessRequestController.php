<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccessRequestController extends Controller
{
    public function index()
    {
        // Busca usuários inativos (pendentes) que NÃO sejam admins
        $requests = User::where('is_active', false)
            ->where('role', '!=', 'admin')
            ->latest()
            ->paginate(10);

        return view('panel.requests.index', compact('requests'));
    }

    public function show(User $user)
    {
        return view('panel.requests.show', compact('user'));
    }

    public function approve(User $user)
    {
        // 1. Gerar senha provisória
        $tempPassword = Str::random(10); // Ex: aB3dE9fG2h

        // 2. Ativar usuário
        $user->update([
            'is_active' => true,
            'password' => Hash::make($tempPassword),
            'email_verified_at' => now(),
        ]);

        // 3. Retornar com a senha para o Admin ver
        return redirect()->route('admin.requests.index')
            ->with('success', 'Usuário aprovado!')
            ->with('temp_password', $tempPassword)
            ->with('approved_user', $user->name);
    }

    public function reject(User $user)
    {
        // Excluir documento se existir
        if ($user->document_path) {
            Storage::disk('public')->delete($user->document_path);
        }

        $user->delete();

        return redirect()->route('admin.requests.index')
            ->with('success', 'Solicitação rejeitada e usuário removido.');
    }
}