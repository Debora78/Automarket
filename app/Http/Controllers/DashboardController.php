<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Se hai una relazione favorites() nel model User
        $favorites = Auth::user()->favorites ?? collect();

        return view('dashboard', [
            'user' => Auth::user(),
            'favorites' => $favorites,
        ]);
    }
}
