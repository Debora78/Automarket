<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce la revisione degli annunci auto da parte dei revisori.
 *
 * Si occupa di:
 * - Mostrare tutti gli annunci in stato "pending"
 * - Approvare un annuncio, impostandone lo stato su "approved"
 * - Rifiutare un annuncio, impostandone lo stato su "rejected"
 *
 * È un componente fondamentale del flusso di moderazione dell’applicazione,
 * permettendo ai revisori di controllare e validare gli annunci prima della pubblicazione.
 */

namespace App\Http\Controllers;
// Namespace che organizza i controller generici dell’applicazione.

use App\Models\Car;
// Importa il modello Car, necessario per recuperare e aggiornare gli annunci.

use Illuminate\Http\Request;
// Importa la classe Request (non utilizzata direttamente, ma utile per estensioni future).

class ReviewerCarController extends Controller
// Controller che gestisce la revisione degli annunci auto.
{
    public function index()
    // Mostra tutti gli annunci in stato "pending" che devono essere revisionati.
    {
        $cars = Car::pending()->get();
        // Recupera tutte le auto con stato "pending" tramite lo scope pending().

        return view('reviewer.cars.index', compact('cars'));
        // Restituisce la vista passando la lista degli annunci da revisionare.
    }

    public function approve(Car $car)
    // Approva un annuncio auto.
    {
        $car->update(['status' => 'approved']);
        // Aggiorna lo stato dell’annuncio a "approved".

        return back()->with('status', 'Annuncio approvato!');
        // Torna alla pagina precedente con un messaggio di conferma.
    }

    public function reject(Car $car)
    // Rifiuta un annuncio auto.
    {
        $car->update(['status' => 'rejected']);
        // Aggiorna lo stato dell’annuncio a "rejected".

        return back()->with('status', 'Annuncio rifiutato.');
        // Torna alla pagina precedente con un messaggio di conferma.
    }
}
