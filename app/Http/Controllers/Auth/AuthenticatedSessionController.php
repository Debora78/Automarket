<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce l’intero ciclo di autenticazione dell’utente
 * tramite Laravel Fortify, includendo:
 *
 * - Visualizzazione della pagina di login
 * - Gestione della richiesta di autenticazione tramite LoginRequest
 * - Rigenerazione sicura della sessione dopo il login
 * - Logout dell’utente e invalidazione della sessione
 *
 * È un componente centrale del sistema di autenticazione e garantisce
 * sicurezza, pulizia e coerenza nel flusso di login/logout dell’applicazione.
 */

namespace App\Http\Controllers\Auth;
// Namespace che organizza i controller relativi all'autenticazione.

use App\Http\Controllers\Controller;
// Importa il controller base di Laravel da cui questo controller eredita.

use App\Http\Requests\Auth\LoginRequest;
// Importa la form request che gestisce la validazione e l'autenticazione dell'utente.

use Illuminate\Http\RedirectResponse;
// Importa la classe per le risposte HTTP di tipo redirect.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

use Illuminate\Support\Facades\Auth;
// Importa la facade Auth per gestire login e logout.

use Illuminate\View\View;
// Importa la classe View per tipizzare il metodo che restituisce una vista.

class AuthenticatedSessionController extends Controller
// Definisce il controller che gestisce login, autenticazione e logout.
{
    /**
     * Display the login view.
     */
    public function create(): View
    // Metodo che mostra la pagina di login.
    {
        return view('auth.login');
        // Restituisce la vista 'auth.login'.
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    // Metodo che gestisce la richiesta di autenticazione.
    {
        $request->authenticate();
        // Esegue l'autenticazione tramite la LoginRequest (controlla credenziali e login).

        $request->session()->regenerate();
        // Rigenera l'ID di sessione per prevenire attacchi di session fixation.

        return redirect()->intended(route('dashboard', absolute: false));
        // Reindirizza l'utente alla pagina che voleva visitare prima del login,
        // oppure alla dashboard se non esiste una destinazione precedente.
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    // Metodo che gestisce il logout dell'utente.
    {
        Auth::guard('web')->logout();
        // Effettua il logout dell'utente dal guard 'web'.

        $request->session()->invalidate();
        // Invalida la sessione corrente per sicurezza.

        $request->session()->regenerateToken();
        // Rigenera il token CSRF per evitare riutilizzi malevoli.

        return redirect('/');
        // Reindirizza l'utente alla homepage dopo il logout.
    }
}
