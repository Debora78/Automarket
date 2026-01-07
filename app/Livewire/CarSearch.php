<?php

namespace App\Http\Livewire;

use App\Models\Car;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CarSearch extends Component
{
    use WithPagination;
    public $search = '';
    public $category_id = '';
    public $price_min = '';
    public $price_max = '';
    public $brand = '';
    public $year = '';
    public $km_max = '';
    public $order = '';

    public function render()
    {
        $cars = Car::with('images', 'category', 'user')
            ->where('is_approved', true)

            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })

            ->when($this->category_id, fn($q) => $q->where('category_id', $this->category_id))

            ->when($this->brand, fn($q) => $q->where('brand', 'like', '%' . $this->brand . '%'))

            ->when($this->year, fn($q) => $q->where('year', $this->year))

            ->when($this->km_max, fn($q) => $q->where('km', '<=', $this->km_max))

            ->when($this->price_min, fn($q) => $q->where('price', '>=', $this->price_min))

            ->when($this->price_max, fn($q) => $q->where('price', '<=', $this->price_max))

            ->when($this->order === 'price_asc', fn($q) => $q->orderBy('price', 'asc'))
            ->when($this->order === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))

            ->latest()
            ->paginate(9);

        return view('livewire.car-search', [
            'cars' => $cars,
            'categories' => Category::all(),
        ]);
    }
}
