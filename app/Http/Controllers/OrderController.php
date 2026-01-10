<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce la visualizzazione degli ordini effettuati
 * dall’utente autenticato.
 *
 * Si occupa di:
 * - Recuperare tutti gli ordini dell’utente, ordinati dal più recente
 * - Mostrare il dettaglio di un singolo ordine
 * - Applicare un controllo di sicurezza per impedire l’accesso a ordini altrui
 *
 * È un controller semplice ma fondamentale per la gestione dell’area personale
 * dell’utente e per la consultazione degli acquisti effettuati.
 */

namespace App\Http\Controllers;
// Namespace che organizza i controller generici dell’applicazione.

use App\Models\Order;
// Importa il modello Order, necessario per recuperare gli ordini dell’utente.

use Illuminate\Http\Request;
// Importa la classe Request (non utilizzata direttamente ma utile per estensioni future).

class OrderController extends Controller
// Controller che gestisce la visualizzazione degli ordini dell’utente autenticato.
{
    public function index()
    // Mostra l’elenco degli ordini dell’utente autenticato.
    {
        $orders = Order::where('user_id', auth()->id())
            // Filtra gli ordini appartenenti all’utente loggato.

            ->orderBy('created_at', 'desc')
            // Ordina gli ordini dal più recente al più vecchio.

            ->get();
        // Recupera tutti gli ordini.

        return view('orders.index', compact('orders'));
        // Restituisce la vista passando la lista degli ordini.
    }

    public function show(Order $order)
    // Mostra il dettaglio di un singolo ordine.
    {
        // Sicurezza: un utente può visualizzare solo i propri ordini.
        if ($order->user_id !== auth()->id()) {
            abort(403);
            // Se l’ordine non appartiene all’utente, restituisce errore 403.
        }

        return view('orders.show', compact('order'));
        // Restituisce la vista passando l’ordine selezionato.
    }
}
