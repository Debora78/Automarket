<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReviewerRequest;
use Illuminate\Support\Facades\Auth;

class ReviewerRequestController extends Controller
{
    public function store()
    {
        // Evita doppie richieste
        if (Auth::user()->reviewerRequest) {
            return back()->with('status', 'Hai già inviato una richiesta.');
        }

        ReviewerRequest::create([
            'user_id' => Auth::id(),
        ]);

        return back()->with('status', 'Richiesta inviata correttamente!');
    }
}
