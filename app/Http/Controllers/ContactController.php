<?php

namespace App\Http\Controllers;

use App\Mail\ContactLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        Log::info('Tentativa de envio de contacto iniciada.', [
            'ip' => $request->ip()
        ]);

        $validated = $request->validate([
            'name'    => 'required|string|min:3|max:255',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:5|max:2000',
        ]);

        try {
            Mail::to('contacto@josecarvalho.pt')->send(new ContactLead($validated));

            Log::info('Sucesso: Lead enviado.');

            return back()->with('success', 'A sua mensagem foi enviada com sucesso! Entraremos em contacto brevemente.');
        } catch (\Exception $e) {
            Log::error('FALHA NO ENVIO: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Ocorreu um erro técnico. Tente novamente.');
        }
    }
}