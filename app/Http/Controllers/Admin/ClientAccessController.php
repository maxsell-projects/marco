<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAccessController extends Controller
{
    /**
     * Mostra a tela de gestão de acesso.
     * Sincronizado com a variável $myClients da View.
     */
    public function manage(Property $property)
    {
        $user = Auth::user();

        // Eager Loading para evitar erro N+1 na verificação de acesso da View
        $property->load('authorizedUsers');

        // RBAC: Admin vê todos (Devs/Clients). Dev vê apenas sua equipe.
        if ($user->isAdmin()) {
            $myClients = User::whereIn('role', ['dev', 'client'])->get();
        } elseif ($user->isDev()) {
            $myClients = $user->team; 
        } else {
            abort(403);
        }

        return view('panel.properties.access', compact('property', 'myClients'));
    }

    /**
     * Liga/Desliga o acesso.
     * Sincronizado com o input 'client_id' do formulário.
     */
    public function toggle(Request $request, Property $property)
    {
        $adminOrDev = Auth::user();
        
        // Buscamos pelo client_id enviado pela sua View
        $targetUser = User::findOrFail($request->client_id);

        // Validação de Segurança (RBAC)
        if ($adminOrDev->isDev()) {
            // 1. Um Dev só gere quem é da equipe dele
            if ($targetUser->parent_id !== $adminOrDev->id) {
                return back()->with('error', 'Acesso negado: Este cliente não pertence à sua carteira.');
            }

            // 2. Um Dev só compartilha o que ele tem acesso ou o que ele cadastrou
            $hasAccess = $adminOrDev->authorizedProperties()->where('property_id', $property->id)->exists();
            $isOwner = ($property->user_id === $adminOrDev->id);

            if (!$hasAccess && !$isOwner) {
                return back()->with('error', 'Você não tem permissão para partilhar este imóvel.');
            }
        }

        // Toggle na pivot com registro de quem deu o acesso (granted_by)
        $property->authorizedUsers()->toggle($targetUser->id, [
            'granted_by' => $adminOrDev->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Acesso atualizado com sucesso!');
    }
}