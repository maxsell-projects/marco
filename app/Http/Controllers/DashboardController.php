<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Property;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Dados para o Admin/Dev (Visão Geral)
        $stats = [];
        if ($user->isAdmin() || $user->isDev()) {
            $stats = [
                'total_properties' => Property::visibleTo($user)->count(),
                'active_clients' => $user->isAdmin() 
                    ? User::where('role', 'client')->count()
                    : $user->clients()->count(),
                'pending_properties' => $user->isAdmin() 
                    ? Property::where('status', 'pending')->count()
                    : 0,
            ];
        }

        // Dados para o Cliente (Seus Interesses)
        $clientData = [];
        if ($user->isClient()) {
            $clientData = [
                'favorites_count' => $user->favorites()->count(),
                'exclusive_access' => $user->accessibleProperties()->count(),
            ];
        }

        return view('dashboard', compact('user', 'stats', 'clientData'));
    }
}