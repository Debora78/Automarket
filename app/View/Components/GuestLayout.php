<?php

/**
 * Componente Blade utilizzato per il layout dedicato agli utenti non autenticati.
 *
 * Questo componente restituisce la vista:
 * resources/views/layouts/guest.blade.php
 *
 * Viene utilizzato per pagine come:
 * - login
 * - registrazione
 * - reset password
 * - pagine pubbliche senza autenticazione
 */

namespace App\View\Components;
// Namespace dedicato ai componenti Blade personalizzati.

use Illuminate\View\Component;
// Classe base per definire un componente Blade.

use Illuminate\View\View;
// Classe che rappresenta una vista renderizzabile.

class GuestLayout extends Component
// Componente che gestisce il layout per gli utenti guest.
{
    /**
     * Restituisce la vista associata al componente.
     *
     * Questo metodo viene chiamato automaticamente da Laravel
     * quando il componente viene renderizzato.
     */
    public function render(): View
    {
        return view('layouts.guest');
        // Restituisce la vista del layout guest.
    }
}
