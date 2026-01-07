<?php

namespace App\Http\Controllers;

use App\Models\Car;

class RevisorController extends Controller
{
    public function index()
    {
        $cars = Car::where('is_approved', false)->get();
        return view('revisor.index', compact('cars'));
    }

    public function accept(Car $car)
    {
        $car->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'Annuncio approvato');
    }

    public function reject(Car $car)
    {
        $car->delete();
        return redirect()->back()->with('success', 'Annuncio rifiutato');
    }
}
