<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce le richieste degli utenti che desiderano diventare revisori.
 *
 * Si occupa di:
 * - Mostrare tutte le richieste in stato "pending"
 * - Accettare una richiesta, aggiornando il ruolo dell’utente e notificandolo
 * - Rifiutare una richiesta, aggiornando lo stato e inviando una notifica
 *
 * È un componente fondamentale del pannello amministrativo e del flusso
 * di moderazione dell’applicazione, garantendo che solo utenti autorizzati
 * possano diventare revisori.
 */

namespace App\Http\Controllers;
// Namespace che organizza i controller generici dell’applicazione.

use Illuminate\Http\Request;
// Importa la classe Request (non utilizzata direttamente ma utile per estensioni future).

use App\Models\ReviewerRequest;
// Modello che rappresenta una richiesta di diventare revisore.

use App\Notifications\ReviewerRejectedNotification;
// Notifica inviata all’utente quando la richiesta viene rifiutata.

class ReviewerRequestController extends Controller
// Controller che gestisce le richieste di revisore.
{
    public function index()
    // Mostra tutte le richieste in stato "pending".
    {
        $requests = ReviewerRequest::with('user')
            // Eager loading della relazione con l’utente.

            ->where('status', 'pending')
            // Filtra solo le richieste ancora da valutare.

            ->get();
        // Recupera tutte le richieste.

        return view('admin.reviewer.index', compact('requests'));
        // Restituisce la vista passando la lista delle richieste.
    }

    public function accept($id)
    // Accetta una richiesta e promuove l’utente a revisore.
    {
        $request = ReviewerRequest::findOrFail($id);
        // Recupera la richiesta tramite ID o lancia un 404 se non esiste.

        $user = $request->user;
        // Recupera l’utente associato alla richiesta.

        // Aggiorna il ruolo corretto
        $user->is_revisor = true;
        // Imposta l’utente come revisore.

        $user->save();
        // Salva la modifica nel database.

        // Aggiorna lo stato della richiesta
        $request->status = 'accepted';
        // Imposta lo stato della richiesta come accettata.

        $request->save();
        // Salva la modifica nel database.

        // Notifica all’utente
        $user->notify(new \App\Notifications\ReviewerAcceptedNotification());
        // Invia una notifica all’utente per informarlo dell’approvazione.

        return back()->with('status', 'Revisore approvato!');
        // Torna alla pagina precedente con un messaggio di conferma.
    }

    public function reject($id)
    // Rifiuta una richiesta di revisore.
    {
        $request = ReviewerRequest::findOrFail($id);
        // Recupera la richiesta tramite ID o lancia un 404.

        $user = $request->user;
        // Recupera l’utente associato.

        // Aggiorna lo stato
        $request->status = 'rejected';
        // Imposta lo stato della richiesta come rifiutata.

        $request->save();
        // Salva la modifica nel database.

        // Notifica all’utente
        $user->notify(new ReviewerRejectedNotification());
        // Invia una notifica informando del rifiuto.

        return back()->with('status', 'Richiesta rifiutata.');
        // Torna alla pagina precedente con un messaggio di conferma.
    }
}
