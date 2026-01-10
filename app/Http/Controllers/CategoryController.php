<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce tutte le operazioni CRUD relative alle categorie
 * utilizzate per classificare le auto all’interno dell’applicazione.
 *
 * Attualmente i metodi sono predisposti ma non ancora implementati.
 * La struttura segue lo standard dei Resource Controller di Laravel e permette:
 *
 * - Visualizzazione dell’elenco delle categorie
 * - Creazione di una nuova categoria
 * - Salvataggio di una categoria nel database
 * - Visualizzazione del dettaglio di una categoria
 * - Modifica di una categoria esistente
 * - Aggiornamento dei dati di una categoria
 * - Eliminazione di una categoria
 *
 * Il controller è pronto per essere completato in base alle esigenze del progetto.
 */

namespace App\Http\Controllers;
// Namespace che organizza i controller generici dell’applicazione.

use App\Models\Category;
// Importa il modello Category, necessario per tutte le operazioni CRUD.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

class CategoryController extends Controller
// Definisce il controller che gestisce le categorie delle auto.
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    // Mostra l’elenco di tutte le categorie (non ancora implementato).
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    // Mostra il form per creare una nuova categoria (non ancora implementato).
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    // Salva una nuova categoria nel database (non ancora implementato).
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    // Mostra il dettaglio di una singola categoria (non ancora implementato).
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    // Mostra il form per modificare una categoria esistente (non ancora implementato).
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    // Aggiorna i dati di una categoria esistente (non ancora implementato).
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    // Elimina una categoria dal database (non ancora implementato).
    {
        //
    }
}
