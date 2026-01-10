<?php
// Apertura del file PHP.

/**
 * Questo componente Livewire gestisce la visualizzazione del dettaglio
 * di una singola auto.
 *
 * Si occupa di:
 * - Ricevere l’istanza del modello Car tramite dependency injection
 * - Impostare la proprietà pubblica $car nel metodo mount()
 * - Restituire la vista dedicata al dettaglio dell’auto
 *
 * È un componente semplice ma fondamentale per mostrare tutte le
 * informazioni relative a un singolo annuncio.
 */

namespace App\Livewire;
// Namespace dedicato ai componenti Livewire.

use App\Models\Car;
// Modello Car, necessario per tipizzare la proprietà e ricevere l’auto.

use Livewire\Component;
// Classe base per i componenti Livewire.

class CarShow extends Component
// Componente Livewire che gestisce la pagina di dettaglio di una singola auto.
{
    public Car $car;
    // Proprietà pubblica che conterrà l’istanza dell’auto da mostrare.

    public function mount(Car $car)
    // Metodo eseguito alla creazione del componente.
    // Riceve automaticamente l’istanza Car dalla rotta.
    {
        $this->car = $car;
        // Assegna l’auto alla proprietà pubblica.
    }

    public function render()
    // Restituisce la vista associata al componente.
    {
        return view('livewire.car-show');
        // La vista utilizzerà $car tramite la proprietà pubblica del componente.
    }
}
