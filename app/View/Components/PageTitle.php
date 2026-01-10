<?php

/**
 * Componente Blade utilizzato per mostrare il titolo di una pagina.
 *
 * Questo componente restituisce la vista:
 * resources/views/components/page-title.blade.php
 *
 * Viene utilizzato per centralizzare la gestione dei titoli
 * e mantenere un layout coerente in tutta l'applicazione.
 */

namespace App\View\Components;
// Namespace dedicato ai componenti Blade personalizzati.

use Closure;
// Classe che rappresenta una funzione anonima utilizzabile come render callback.

use Illuminate\Contracts\View\View;
// Interfaccia che rappresenta una vista renderizzabile.

use Illuminate\View\Component;
// Classe base per definire un componente Blade.

class PageTitle extends Component
// Componente che gestisce il titolo di una pagina.
{
    /**
     * Costruttore del componente.
     *
     * Attualmente non riceve parametri, ma può essere esteso
     * per accettare titoli dinamici in futuro.
     */
    public function __construct()
    {
        //
    }

    /**
     * Restituisce la vista associata al componente.
     *
     * Questo metodo viene chiamato automaticamente da Laravel
     * quando il componente viene renderizzato.
     */
    public function render(): View|Closure|string
    {
        return view('components.page-title');
        // Restituisce la vista del titolo pagina.
    }
}
