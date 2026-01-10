<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce la dashboard dell’utente autenticato.
 *
 * Si occupa di:
 * - Recuperare l’utente loggato tramite Auth
 * - Recuperare la lista dei preferiti, se la relazione favorites() è presente nel model User
 * - Passare i dati necessari alla vista dashboard
 *
 * È un controller semplice ma centrale per la personalizzazione dell’area utente.
 */

namespace App\Http\Controllers;
// Namespace che organizza i controller generici dell’applicazione.

use Illuminate\Support\Facades\Auth;
// Importa la facade Auth per recuperare l’utente autenticato.

class DashboardController extends Controller
// Controller che gestisce la dashboard dell’utente autenticato.
{
    public function index()
    // Mostra la dashboard dell’utente.
    {
        // Se nel model User esiste una relazione favorites(),
        // recupera i preferiti dell’utente; altrimenti usa una collection vuota.
        $favorites = Auth::user()->favorites ?? collect();

        return view('dashboard', [
            'user' => Auth::user(),
            // Passa l’utente autenticato alla vista.

            'favorites' => $favorites,
            // Passa la lista dei preferiti (o una collection vuota).
        ]);
    }
}
