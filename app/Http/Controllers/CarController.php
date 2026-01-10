<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce tutte le operazioni CRUD relative agli annunci auto.
 *
 * Si occupa di:
 * - Mostrare la lista delle auto approvate e paginate
 * - Mostrare il form di creazione di un nuovo annuncio
 * - Validare e salvare un nuovo annuncio nel database
 * - Mostrare il dettaglio di una singola auto
 *
 * Le operazioni di modifica e cancellazione sono predisposte ma non ancora implementate.
 * Il controller utilizza eager loading e uno scope personalizzato per ottimizzare le query.
 */

namespace App\Http\Controllers;
// Namespace che organizza i controller generici dell’applicazione.

use App\Models\Car;
// Importa il modello Car, necessario per tutte le operazioni CRUD.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

use function PHPSTORM_META\type;
// Funzione interna di PhpStorm (non necessaria in produzione, ma innocua).

class CarController extends Controller
// Definisce il controller che gestisce gli annunci auto.
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    // Mostra la lista delle auto approvate e paginate.
    {
        $cars = Car::with('images', 'category', 'user')
            // Eager loading delle relazioni per evitare query N+1.

            ->approved()
            // Usa lo scope 'approved' definito nel modello Car.

            ->latest()
            // Ordina le auto dalla più recente alla più vecchia.

            ->paginate(12);
        // Pagina i risultati, 12 per pagina.

        return view('cars.index', compact('cars'));
        // Restituisce la vista passando la lista delle auto.
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    // Mostra il form per creare un nuovo annuncio auto.
    {
        return view('cars.create');
        // Restituisce la vista 'cars.create'.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    // Gestisce la creazione di un nuovo annuncio auto.
    {
        $validated = $request->validate([
            // Valida i dati inviati dal form.

            'title' => 'required|string|max:255',
            // Titolo obbligatorio.

            'description' => 'required|string|max:2000',
            // Descrizione obbligatoria.

            'brand' => 'required|string|max:255',
            // Marca obbligatoria.

            'model' => 'required|string|max:255',
            // Modello obbligatorio.

            'price' => 'required|numeric|min:0',
            // Prezzo obbligatorio e non negativo.

            'category_id' => 'required|exists:categories,id',
            // La categoria deve esistere nella tabella categories.

            'type' => 'required|in:sale_new,sale_used,rental',
            // Tipo obbligatorio: nuovo, usato o noleggio.

            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            // Anno opzionale ma valido.

            'km' => 'nullable|integer|min:0',
            // Chilometraggio opzionale ma non negativo.

            'color' => 'nullable|string|max:50',
            // Colore opzionale.

            'accessories' => 'nullable|array',
            // Accessori opzionali, devono essere un array.

            'images.*' => 'nullable|image|max:2048',
            // Ogni immagine deve essere valida e max 2MB.
        ]);

        $car = Car::create([
            // Crea un nuovo record nella tabella cars.

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
            // Tipo dell’annuncio (nuovo, usato, noleggio).

            'status' => 'pending',
            // Lo stato iniziale è "pending" in attesa di approvazione.

            'user_id' => auth()->id(),
            // Associa l’annuncio all’utente autenticato.
        ]);

        return redirect()->route('cars.index')->with('success', 'Annuncio inserito con successo!');
        // Reindirizza alla lista delle auto con messaggio di successo.
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    // Mostra il dettaglio di una singola auto.
    {
        $car->load('images', 'category', 'user');
        // Eager loading delle relazioni per ottimizzare la query.

        return view('cars.show', compact('car'));
        // Restituisce la vista passando l’auto selezionata.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    // Mostra il form per modificare un annuncio (non ancora implementato).
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    // Aggiorna un annuncio esistente (non ancora implementato).
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    // Elimina un annuncio (non ancora implementato).
    {
        //
    }
}
