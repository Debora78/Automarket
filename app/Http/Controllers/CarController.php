<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::with('images', 'category', 'user')
            ->approved() // usa lo scope
            ->latest()
            ->paginate(12);

        return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:sale_new,sale_used,rental',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'km' => 'nullable|integer|min:0',
            'color' => 'nullable|string|max:50',
            'accessories' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $car = Car::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'year' => $validated['year'],
            'km' => $validated['km'],
            'color' => $validated['color'],
            'type' => $validated['type'], // CORRETTO
            'status' => 'pending',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('cars.index')->with('success', 'Annuncio inserito con successo!');
    }



    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        $car->load('images', 'category', 'user');

        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }
}
