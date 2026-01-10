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
// Namespace dedicato ai componenti Livewire.

use App\Models\Car;
// Modello Car, necessario per costruire la query filtrata.

use App\Models\Category;
// Modello Category, usato per popolare il filtro categorie.

use Livewire\Component;
// Classe base per i componenti Livewire.

class CarIndex extends Component
// Componente Livewire che gestisce la lista delle auto con filtri dinamici.
{
    // FILTRI
    public $filter_type = '';
    // Filtro per tipo annuncio (sale_new, sale_used, rental).

    public $filter_color = '';
    // Filtro per colore dell’auto.

    public $filter_accessories = [];
    // Filtro per accessori (array di valori JSON).

    public $filter_price_min = null;
    // Prezzo minimo.

    public $filter_price_max = null;
    // Prezzo massimo.

    public $filter_category = '';
    // Categoria dell’auto.

    public $filter_brand = '';
    // Marca dell’auto (ricerca LIKE).

    public $filter_year = '';
    // Anno di immatricolazione.

    public function render()
    // Metodo principale: costruisce la query filtrata e restituisce la vista.
    {
        $cars = Car::query()
            // Inizia una query base sul modello Car.

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
                        // Ogni accessorio deve essere contenuto nel JSON.
                    }
                })
            )

            ->latest()
            // Ordina dalla più recente.

            ->paginate(12);
        // Paginazione dei risultati.

        return view('livewire.car-index', [
            'cars' => $cars,
            // Risultati filtrati.

            'categories' => Category::all(),
            // Categorie per il filtro laterale.
        ])->layout('components.layout');
        // Usa il layout principale dell’app.
    }

    public function mount()
    // Metodo eseguito alla creazione del componente.
    {
        $route = request()->route()->getName();
        // Recupera il nome della rotta corrente.

        // Se siamo nelle pagine dedicate, imposta automaticamente il filtro
        if (in_array($route, ['cars.new', 'cars.used', 'cars.rental'])) {

            $this->filter_type = match ($route) {
                'cars.new' => 'sale_new',
                'cars.used' => 'sale_used',
                'cars.rental' => 'rental',
            };
            // Imposta il tipo annuncio in base alla rotta.
        } else {
            // Altrimenti usa i filtri da query string (pagina Annunci)

            if (request()->has('type')) {
                $this->filter_type = request()->get('type');
                // Imposta il tipo da query string.
            }

            if (request()->has('category')) {
                $this->filter_category = request()->get('category');
                // Imposta la categoria da query string.
            }
        }
    }

    public function applyFilters()
    // Metodo chiamato quando l’utente applica i filtri.
    {
        $this->resetPage();
        // Reset della paginazione per evitare di restare su pagine vuote.
    }
}
