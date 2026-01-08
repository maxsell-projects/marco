<?php

namespace App\Http\Controllers;

use App\Mail\ContactLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Processa o formulário de contacto e envia o email.
     * Refatorado para garantir resiliência e debug em produção.
     */
    public function send(Request $request)
    {
        // 1. Log de Entrada: Verifica se os dados estão sequer a chegar ao servidor
        Log::info('Tentativa de envio de contacto iniciada.', [
            'ip' => $request->ip(),
            'payload' => $request->except(['_token']) 
        ]);

        // 2. Validação Rigorosa
        // Se a validação falhar, o Laravel redireciona automaticamente para trás.
        $validated = $request->validate([
            'name'    => 'required|string|min:3|max:255',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:5|max:2000',
        ]);

        try {
            // 3. Envio do Email
            // O destinatário dmgmaia@remax.pt receberá o lead formatado.
            // Se o ContactLead implementar ShouldQueue, ele irá para a fila automaticamente.
            Mail::to('contacto@diogomaia.pt')->send(new ContactLead($validated));

            Log::info('Sucesso: Job de e-mail enviado/enfileirado.', ['to' => 'dmgmaia@remax.pt']);

            return back()->with('success', 'A sua mensagem foi enviada com sucesso! Entraremos em contacto brevemente.');

        } catch (\Exception $e) {
            // 4. Tratamento de Erro Detalhado
            // Aqui capturamos erros de SMTP, conexão ou falha na base de dados (queues)
            Log::error('FALHA CRÍTICA NO CONTACTO: ' . $e->getMessage(), [
                'exception' => $e,
                'data' => $validated
            ]);

            return back()
                ->withInput()
                ->with('error', 'Ocorreu um erro técnico: ' . $e->getMessage());
        }
    }
}