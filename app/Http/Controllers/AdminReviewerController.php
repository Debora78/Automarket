<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce la revisione delle richieste inviate dagli utenti
 * che desiderano diventare revisori all’interno dell’applicazione.
 *
 * Si occupa di:
 * - Mostrare tutte le richieste in stato "pending"
 * - Accettare una richiesta, aggiornando il ruolo dell’utente a "reviewer"
 * - Rifiutare una richiesta, aggiornandone lo stato a "rejected"
 * - Restituire feedback tramite messaggi di stato
 *
 * È un componente fondamentale del pannello amministrativo e permette
 * di gestire in modo semplice e sicuro il flusso di approvazione dei revisori.
 */

namespace App\Http\Controllers;
// Namespace che organizza i controller generici dell’applicazione.

use App\Http\Controllers\Controller;
// Importa il controller base di Laravel da cui questo controller eredita.

use App\Models\ReviewerRequest;
// Importa il modello ReviewerRequest, che rappresenta una richiesta di diventare revisore.

class AdminReviewerController extends Controller
// Definisce il controller che gestisce le richieste dei revisori nel pannello admin.
{
    public function index()
    // Mostra tutte le richieste di revisione in stato "pending".
    {
        $requests = ReviewerRequest::with('user')->where('status', 'pending')->get();
        // Recupera tutte le richieste pendenti, includendo la relazione con l’utente.

        return view('admin.reviewer.index', compact('requests'));
        // Restituisce la vista passando l’elenco delle richieste.
    }

    public function accept($id)
    // Accetta una richiesta e promuove l’utente a revisore.
    {
        $request = ReviewerRequest::findOrFail($id);
        // Recupera la richiesta tramite ID o lancia un 404 se non esiste.

        $user = $request->user;
        // Recupera l’utente associato alla richiesta.

        $user->role = 'reviewer';
        // Imposta il ruolo dell’utente come "reviewer".

        $user->save();
        // Salva la modifica nel database.

        $request->status = 'accepted';
        // Aggiorna lo stato della richiesta a "accepted".

        $request->save();
        // Salva la modifica nel database.

        return back()->with('status', 'Revisore approvato!');
        // Torna alla pagina precedente con un messaggio di successo.
    }

    public function reject($id)
    // Rifiuta una richiesta di revisore.
    {
        $request = ReviewerRequest::findOrFail($id);
        // Recupera la richiesta tramite ID o lancia un 404 se non esiste.

        $request->status = 'rejected';
        // Imposta lo stato della richiesta a "rejected".

        $request->save();
        // Salva la modifica nel database.

        return back()->with('status', 'Richiesta rifiutata.');
        // Torna alla pagina precedente con un messaggio di stato.
    }
}
