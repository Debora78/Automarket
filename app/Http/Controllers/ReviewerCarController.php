<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class ReviewerCarController extends Controller
{
    public function index()
    {
        $cars = Car::pending()->get();
        return view('reviewer.cars.index', compact('cars'));
    }

    public function approve(Car $car)
    {
        $car->update(['status' => 'approved']);
        return back()->with('status', 'Annuncio approvato!');
    }

    public function reject(Car $car)
    {
        $car->update(['status' => 'rejected']);
        return back()->with('status', 'Annuncio rifiutato.');
    }
}
