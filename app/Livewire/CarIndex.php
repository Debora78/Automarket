<?php
// Apertura del file PHP.

/**
 * Questo componente Livewire gestisce la pagina di elenco delle auto,
 * includendo tutti i filtri dinamici applicabili dagli utenti.
 *
 * Si occupa di:
 * - Gestire i filtri (tipo annuncio, colore, categoria, marca, anno, prezzo, accessori)
 * - Applicare i filtri in modo reattivo tramite query condizionali
 * - Paginare i risultati
 * - Impostare automaticamente il filtro tipo in base alla rotta visitata
 * - Supportare filtri provenienti dalla query string
 *
 * È un componente centrale per la UX della sezione Annunci, permettendo
 * una ricerca avanzata e immediata senza ricaricare la pagina.
 */

namespace App\Livewire;

use App\Models\Car;       // Modello Car, necessario per costruire la query filtrata.
use App\Models\Category;  // Modello Category, usato per popolare il filtro categorie.
use Livewire\Component;   // Classe base per i componenti Livewire.

class CarIndex extends Component
{
    // ----------------------------------------------------------------------
    // FILTRI DISPONIBILI
    // ----------------------------------------------------------------------

    public $filter_type = '';          // Tipo annuncio (sale_new, sale_used, rental)
    public $filter_color = '';         // Colore dell’auto
    public $filter_accessories = [];   // Accessori (array JSON)
    public $filter_price_min = null;   // Prezzo minimo
    public $filter_price_max = null;   // Prezzo massimo
    public $filter_category = '';      // Categoria dell’auto
    public $filter_brand = '';         // Marca (ricerca LIKE)
    public $filter_year = '';          // Anno di immatricolazione

    // ----------------------------------------------------------------------
    // MOUNT: inizializzazione del componente
    // ----------------------------------------------------------------------
    public function mount()
    {
        $route = request()->route()->getName();
        // Recupera il nome della rotta corrente.

        // Se siamo nelle pagine dedicate, imposta automaticamente il filtro tipo
        if (in_array($route, ['cars.new', 'cars.used', 'cars.rental'])) {

            $this->filter_type = match ($route) {
                'cars.new'   => 'sale_new',
                'cars.used'  => 'sale_used',
                'cars.rental' => 'rental',
            };
            // Imposta il tipo annuncio in base alla rotta.

        } else {
            // Altrimenti usa i filtri da query string (pagina Annunci)

            if (request()->has('type')) {
                $this->filter_type = request()->get('type');
            }

            if (request()->has('category')) {
                $this->filter_category = request()->get('category');
            }
        }
    }

    // ----------------------------------------------------------------------
    // RENDER: costruisce la query filtrata e restituisce la vista
    // ----------------------------------------------------------------------
    public function render()
    {
        $cars = Car::query()

            // Tipo annuncio
            ->when(
                $this->filter_type,
                fn($q) =>
                $q->where('listing_type', $this->filter_type)
            )

            // Colore
            ->when(
                $this->filter_color,
                fn($q) =>
                $q->where('color', $this->filter_color)
            )

            // Categoria
            ->when(
                $this->filter_category,
                fn($q) =>
                $q->where('category_id', $this->filter_category)
            )

            // Marca
            ->when(
                $this->filter_brand,
                fn($q) =>
                $q->where('brand', 'like', "%{$this->filter_brand}%")
            )

            // Anno
            ->when(
                $this->filter_year,
                fn($q) =>
                $q->where('year', $this->filter_year)
            )

            // Prezzo minimo
            ->when(
                $this->filter_price_min,
                fn($q) =>
                $q->where('price', '>=', $this->filter_price_min)
            )

            // Prezzo massimo
            ->when(
                $this->filter_price_max,
                fn($q) =>
                $q->where('price', '<=', $this->filter_price_max)
            )

            // Accessori (JSON)
            ->when(
                count($this->filter_accessories) > 0,
                fn($q) =>
                $q->where(function ($query) {
                    foreach ($this->filter_accessories as $acc) {
                        $query->whereJsonContains('accessories', $acc);
                    }
                })
            )

            ->latest()       // Ordina dalla più recente
            ->paginate(12);  // Paginazione

        return view('livewire.car-index', [
            'cars' => $cars,
            'categories' => Category::all(),
        ])->layout('components.layout');
    }

    // ----------------------------------------------------------------------
    // METODI PUBBLICI
    // ----------------------------------------------------------------------

    public function applyFilters()
    {
        $this->resetPage();
        // Reset della paginazione per evitare di restare su pagine vuote.
    }
}
