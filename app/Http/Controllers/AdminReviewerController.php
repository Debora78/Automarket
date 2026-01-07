<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReviewerRequest;

class AdminReviewerController extends Controller
{
    public function index()
    {
        $requests = ReviewerRequest::with('user')->where('status', 'pending')->get();
        return view('admin.reviewer.index', compact('requests'));
    }

    public function accept($id)
    {
        $request = ReviewerRequest::findOrFail($id);
        $user = $request->user;

        $user->role = 'reviewer';
        $user->save();

        $request->status = 'accepted';
        $request->save();

        return back()->with('status', 'Revisore approvato!');
    }

    public function reject($id)
    {
        $request = ReviewerRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return back()->with('status', 'Richiesta rifiutata.');
    }
}
