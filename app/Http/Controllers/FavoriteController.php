<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('images')->paginate(9);
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Property $property)
    {
        $user = Auth::user();
        $user->favorites()->toggle($property->id);

        return back()->with('success', 'Lista de favoritos atualizada.');
    }
}