<?php

namespace App\Livewire;

use App\Models\Car;
use Livewire\Component;

class CarShow extends Component
{
    public Car $car;

    public function mount(Car $car)
    {
        $this->car = $car;
    }

    public function render()
    {
        return view('livewire.car-show');
    }
}
