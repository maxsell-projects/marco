<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAccessController extends Controller
{
    public function manage(Property $property)
    {
        $user = Auth::user();

        // Eager loading para evitar erro N+1 na verificação da View
        $property->load('authorizedUsers');

        // AJUSTE: Sincronizado com a sua View que usa a variável $myClients
        $myClients = $user->isAdmin() 
            ? User::whereIn('role', ['dev', 'client'])->get() 
            : $user->team;

        return view('panel.properties.access', compact('property', 'myClients'));
    }

    public function toggle(Request $request, Property $property)
    {
        $adminOrDev = Auth::user();
        
        // AJUSTE: Sincronizado com o <input name="client_id"> da sua View
        $targetUser = User::findOrFail($request->client_id);

        if ($adminOrDev->isDev()) {
            if ($targetUser->parent_id !== $adminOrDev->id) {
                return back()->with('error', 'Acesso negado: Este cliente não pertence à sua carteira.');
            }

            $hasAccess = $adminOrDev->authorizedProperties()->where('property_id', $property->id)->exists();
            $isOwner = ($property->user_id === $adminOrDev->id);

            if (!$hasAccess && !$isOwner) {
                return back()->with('error', 'Você não tem permissão para partilhar este imóvel.');
            }
        }

        /**
         * CORREÇÃO DO ERRO DE SQL: 
         * Usamos o formato [ID => ATRIBUTOS] no toggle. Isso garante que o Laravel
         * mapeie corretamente o 'granted_by' para a coluna da tabela pivot.
         */
        $property->authorizedUsers()->toggle([
            $targetUser->id => [
                'granted_by' => $adminOrDev->id
            ]
        ]);

        return back()->with('success', 'Acesso atualizado com sucesso!');
    }
}