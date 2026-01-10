<?php
// Apertura del file PHP.

/**
 * Componente Blade che rappresenta il layout principale dell'applicazione.
 *
 * Questo componente viene utilizzato per incapsulare la struttura
 * HTML comune a tutte le pagine (header, footer, layout generale).
 *
 * Quando incluso in una vista, restituisce il file:
 * resources/views/layouts/app.blade.php
 */

namespace App\View\Components;
// Namespace dedicato ai componenti Blade personalizzati.

use Illuminate\View\Component;
// Classe base per definire un componente Blade.

use Illuminate\View\View;
// Classe che rappresenta una vista renderizzabile.


class AppLayout extends Component
{
    /**
     * Restituisce la vista associata al componente.
     *
     * Questo metodo viene chiamato automaticamente da Laravel
     * quando il componente viene renderizzato.
     */
    public function render(): View
    {
        return view('layouts.app');
        // Restituisce la vista principale del layout.
    }
}
