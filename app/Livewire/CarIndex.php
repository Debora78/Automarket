<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\Category;
use Livewire\Component;

class CarIndex extends Component
{
    // FILTRI
    public $filter_type = '';
    public $filter_color = '';
    public $filter_accessories = [];
    public $filter_price_min = null;
    public $filter_price_max = null;
    public $filter_category = '';
    public $filter_brand = '';
    public $filter_year = '';

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

            // Accessori
            ->when(
                count($this->filter_accessories) > 0,
                fn($q) =>
                $q->where(function ($query) {
                    foreach ($this->filter_accessories as $acc) {
                        $query->whereJsonContains('accessories', $acc);
                    }
                })
            )

            ->latest()
            ->get();

        return view('livewire.car-index', [
            'cars' => $cars,
            'categories' => Category::all(),
        ])->layout('components.layout');
    }
    public function mount()
    {
        $route = request()->route()->getName();

        // Se siamo nelle pagine dedicate, imposta automaticamente il filtro
        if (in_array($route, ['cars.new', 'cars.used', 'cars.rental'])) {

            $this->filter_type = match ($route) {
                'cars.new' => 'sale_new',
                'cars.used' => 'sale_used',
                'cars.rental' => 'rental',
            };
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

    public function applyFilters()
    {
        $this->resetPage(); // se usi paginazione
    }
}
