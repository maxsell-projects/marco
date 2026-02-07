<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\AccessRequestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str; // <--- CORRIGIDO AQUI (Era Facades\Str)
use Illuminate\Support\Facades\Log;

class RequestAccessController extends Controller
{
    public function show()
    {
        return view('access.request');
    }

    public function submit(Request $request)
    {
        // 1. Validação
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'type' => 'required|in:client,dev', // Valida se é Cliente ou Dev
            'motivation' => 'required|string|min:10|max:1000',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'consent' => 'accepted'
        ]);

        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('documents/requests', 'public');
        }

        // 2. Criar Usuário (Inativo)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'],
            'password' => Hash::make(Str::random(40)), // Agora vai funcionar!
            'is_active' => false,
            'role' => $validated['type'], // Salva se é 'client' ou 'dev'
            'notes' => $validated['motivation'],
            'document_path' => $documentPath,
        ]);

        // 3. Notificar Admin
        try {
            Mail::to(config('mail.from.address'))
                ->send(new AccessRequestMail($user));
        } catch (\Exception $e) {
            Log::error('Erro email solicitação: ' . $e->getMessage());
        }

        return back()->with('success', __('access.form.success_message'));
    }
}