<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce la visualizzazione della homepage pubblica
 * dell’applicazione.
 *
 * Si occupa semplicemente di:
 * - Restituire la vista principale "welcome"
 *
 * È un controller minimale, ma rappresenta il punto di ingresso per gli utenti
 * non autenticati e può essere esteso in futuro per includere contenuti dinamici.
 */

namespace App\Http\Controllers;
// Namespace che organizza i controller generici dell’applicazione.

use Illuminate\Http\Request;
// Importa la classe Request (attualmente non utilizzata, ma pronta per futuri sviluppi).

class HomeController extends Controller
// Controller che gestisce la homepage pubblica.
{
    public function index()
    // Mostra la pagina principale dell’applicazione.
    {
        return view('welcome');
        // Restituisce la vista 'welcome', tipicamente la landing page.
    }
}
