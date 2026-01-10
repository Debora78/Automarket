<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce il carrello dell’utente non autenticato,
 * utilizzando l’ID di sessione per identificare gli articoli aggiunti.
 *
 * Si occupa di:
 * - Mostrare gli articoli presenti nel carrello
 * - Aggiungere un’auto al carrello evitando duplicati tramite firstOrCreate
 * - Rimuovere un articolo dal carrello
 *
 * Il carrello è basato sulla sessione, quindi funziona anche senza login.
 * Le relazioni vengono caricate tramite eager loading per ottimizzare le query.
 */

namespace App\Http\Controllers;
// Namespace che organizza i controller generici dell’applicazione.

use App\Models\Car;
// Importa il modello Car, necessario per aggiungere auto al carrello.

use App\Models\CartItem;
// Importa il modello CartItem, che rappresenta un elemento del carrello.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

use Illuminate\Support\Facades\Auth;
// Importa la facade Auth (non utilizzata in questo file, ma innocua).

class CartController extends Controller
// Definisce il controller che gestisce il carrello basato sulla sessione.
{
    public function index()
    // Mostra tutti gli articoli presenti nel carrello dell’utente.
    {
        $sessionId = session()->getId();
        // Recupera l’ID della sessione corrente, usato per identificare il carrello.

        $items = CartItem::with('car')
            // Eager loading della relazione con il modello Car.

            ->where('session_id', $sessionId)
            // Filtra gli articoli appartenenti alla sessione corrente.

            ->get();
        // Recupera tutti gli articoli del carrello.

        return view('cart.index', compact('items'));
        // Restituisce la vista passando gli articoli del carrello.
    }

    public function add(Car $car)
    // Aggiunge un’auto al carrello.
    {
        $sessionId = session()->getId();
        // Recupera l’ID della sessione corrente.

        CartItem::firstOrCreate(
            [
                'session_id' => $sessionId,
                // Identifica il carrello tramite la sessione.

                'car_id' => $car->id,
                // Identifica l’auto da aggiungere.
            ],
            [
                'quantity' => 1,
                // Se l’elemento non esiste, viene creato con quantità = 1.
            ]
        );
        // firstOrCreate evita duplicati: se l’auto è già nel carrello, non viene aggiunta di nuovo.

        return back()->with('success', 'Auto aggiunta al carrello!');
        // Torna alla pagina precedente con un messaggio di successo.
    }

    public function remove(CartItem $item)
    // Rimuove un articolo dal carrello.
    {
        $item->delete();
        // Elimina l’elemento dal database.

        return back()->with('success', 'Auto rimossa dal carrello.');
        // Torna alla pagina precedente con un messaggio di conferma.
    }
}
