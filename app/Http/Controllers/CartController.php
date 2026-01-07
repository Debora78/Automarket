<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $sessionId = session()->getId();

        $items = CartItem::with('car')
            ->where('session_id', $sessionId)
            ->get();

        return view('cart.index', compact('items'));
    }

    public function add(Car $car)
    {
        $sessionId = session()->getId();

        CartItem::firstOrCreate(
            [
                'session_id' => $sessionId,
                'car_id' => $car->id,
            ],
            [
                'quantity' => 1,
            ]
        );

        return back()->with('success', 'Auto aggiunta al carrello!');
    }

    public function remove(CartItem $item)
    {
        $item->delete();

        return back()->with('success', 'Auto rimossa dal carrello.');
    }
}
