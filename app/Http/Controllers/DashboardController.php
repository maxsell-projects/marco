<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Dados Padrão (Vazios)
        $stats = [
            'total_properties' => 0,
            'active_clients' => 0,
            'pending_reviews' => 0
        ];
        
        $clientData = [
            'favorites_count' => 0,
            'exclusive_access' => 0
        ];

        // Lógica por Papel (Role)
        if ($user->isAdmin()) {
            // ADMIN: Visão Global
            $stats['total_properties'] = Property::count();
            $stats['active_clients'] = User::where('role', 'client')->where('is_active', true)->count();
            $stats['pending_reviews'] = Property::where('status', 'pending')->count(); // Imóveis para aprovar
            
            // + Solicitações de Acesso Pendentes
            $stats['access_requests'] = User::where('is_active', false)->count();

        } elseif ($user->isDev()) {
            // DEV: Visão do Portfólio Próprio
            $stats['total_properties'] = Property::where('user_id', $user->id)->count();
            // Clientes atribuídos a este Dev (futuro) ou Total Global (por enquanto)
            $stats['active_clients'] = 0; // Implementar se tiver relacionamento Dev->Client
            $stats['pending_reviews'] = Property::where('user_id', $user->id)->where('status', 'pending')->count(); // Meus pendentes

        } else {
            // CLIENTE: Visão Pessoal
            // Implementar lógica de favoritos e acesso off-market
            $clientData['favorites_count'] = 0; // $user->favorites()->count();
            $clientData['exclusive_access'] = $user->authorizedProperties()->count();
        }

        return view('dashboard', compact('user', 'stats', 'clientData'));
    }
}