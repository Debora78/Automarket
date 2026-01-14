<?php
// Apertura del file PHP.

/**
 * Questo componente Livewire gestisce la ricerca avanzata delle auto,
 * applicando filtri dinamici e ordinamenti personalizzati.
 *
 * Si occupa di:
 * - Filtrare per testo, categoria, marca, anno, km, prezzo minimo/massimo
 * - Ordinare i risultati per prezzo crescente o decrescente
 * - Mostrare solo le auto approvate
 * - Paginare i risultati
 *
 * È un componente fondamentale per la UX della pagina di ricerca,
 * permettendo un'esperienza fluida e reattiva senza ricaricare la pagina.
 */

namespace App\Http\Livewire;

use App\Models\Car;          // Modello Car, necessario per costruire la query filtrata.
use App\Models\Category;     // Modello Category, usato per popolare il filtro categorie.
use Livewire\Component;      // Classe base per i componenti Livewire.
use Livewire\WithPagination; // Trait che abilita la paginazione nei componenti Livewire.

class CarSearch extends Component
{
    use WithPagination; // Abilita la paginazione automatica.

    // ----------------------------------------------------------------------
    // FILTRI DISPONIBILI
    // ----------------------------------------------------------------------

    public $search = '';        // Testo di ricerca (titolo o descrizione).
    public $category_id = '';   // Filtro per categoria.
    public $price_min = '';     // Prezzo minimo.
    public $price_max = '';     // Prezzo massimo.
    public $brand = '';         // Filtro per marca.
    public $year = '';          // Filtro per anno.
    public $km_max = '';        // Filtro per chilometraggio massimo.
    public $order = '';         // Ordinamento (price_asc, price_desc).

    // ----------------------------------------------------------------------
    // RENDER: costruisce la query filtrata e restituisce la vista
    // ----------------------------------------------------------------------
    public function render()
    {
        $cars = Car::with('images', 'category', 'user')
            // Eager loading delle relazioni principali.

            ->where('is_approved', true)
            // Mostra solo auto approvate.

            // Ricerca testuale su titolo e descrizione
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })

            // Categoria
            ->when(
                $this->category_id,
                fn($q) =>
                $q->where('category_id', $this->category_id)
            )

            // Marca
            ->when(
                $this->brand,
                fn($q) =>
                $q->where('brand', 'like', '%' . $this->brand . '%')
            )

            // Anno
            ->when(
                $this->year,
                fn($q) =>
                $q->where('year', $this->year)
            )

            // Chilometraggio massimo
            ->when(
                $this->km_max,
                fn($q) =>
                $q->where('km', '<=', $this->km_max)
            )

            // Prezzo minimo
            ->when(
                $this->price_min,
                fn($q) =>
                $q->where('price', '>=', $this->price_min)
            )

            // Prezzo massimo
            ->when(
                $this->price_max,
                fn($q) =>
                $q->where('price', '<=', $this->price_max)
            )

            // Ordinamento per prezzo crescente
            ->when(
                $this->order === 'price_asc',
                fn($q) =>
                $q->orderBy('price', 'asc')
            )

            // Ordinamento per prezzo decrescente
            ->when(
                $this->order === 'price_desc',
                fn($q) =>
                $q->orderBy('price', 'desc')
            )

            ->latest()     // Ordina per data di creazione (fallback).
            ->paginate(9); // Paginazione dei risultati.

        return view('livewire.car-search', [
            'cars' => $cars,                 // Risultati filtrati.
            'categories' => Category::all(), // Categorie disponibili per il filtro.
        ]);
    }
}
