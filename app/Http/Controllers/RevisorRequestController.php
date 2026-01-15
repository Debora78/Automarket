<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RevisorRequestController extends Controller
{
    /**
     * Mostra la pagina con il form per diventare revisore.
     */
    public function create()
    {
        return view('reviewer.request');
    }

    /**
     * Gestisce l'invio della richiesta per diventare revisore.
     * - Valida l'email inserita dall'utente
     * - (In futuro) salva la richiesta o invia una notifica
     * - Restituisce un messaggio di successo
     */
    public function store(Request $request)
    {
        // Validazione del campo email (obbligatorio + formato valido)
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Qui potresti salvare la richiesta nel database o inviare una mail
        // Per ora restituiamo solo un messaggio di conferma
        return back()->with('revisor_request_success', 'Richiesta inviata con successo');
    }
}
