<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce la conferma della password dell’utente,
 * una misura di sicurezza utilizzata da Laravel Fortify per proteggere
 * azioni sensibili come modifiche al profilo, eliminazione dell’account
 * o accesso a sezioni critiche dell’applicazione.
 *
 * Si occupa di:
 * - Mostrare la pagina di conferma password
 * - Validare la password inserita confrontandola con quella dell’utente autenticato
 * - Registrare il timestamp della conferma nella sessione
 *
 * Garantisce che l’utente abbia recentemente confermato la propria identità
 * prima di procedere con operazioni ad alta sensibilità.
 */

namespace App\Http\Controllers\Auth;
// Namespace che organizza i controller relativi all'autenticazione.

use App\Http\Controllers\Controller;
// Importa il controller base di Laravel da cui questo controller eredita.

use Illuminate\Http\RedirectResponse;
// Importa la classe per risposte HTTP di tipo redirect.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

use Illuminate\Support\Facades\Auth;
// Importa la facade Auth per validare le credenziali dell’utente.

use Illuminate\Validation\ValidationException;
// Importa l’eccezione usata per restituire errori di validazione.

use Illuminate\View\View;
// Importa la classe View per tipizzare il metodo che restituisce una vista.

class ConfirmablePasswordController extends Controller
// Definisce il controller che gestisce la conferma della password.
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    // Metodo che mostra la pagina in cui l’utente deve confermare la password.
    {
        return view('auth.confirm-password');
        // Restituisce la vista 'auth.confirm-password'.
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    // Metodo che gestisce la conferma della password inserita dall’utente.
    {
        if (! Auth::guard('web')->validate([
            // Verifica se le credenziali fornite sono valide.

            'email' => $request->user()->email,
            // Usa l’email dell’utente autenticato.

            'password' => $request->password,
            // Confronta la password inserita con quella salvata.
        ])) {
            // Se la validazione fallisce:

            throw ValidationException::withMessages([
                'password' => __('auth.password'),
                // Restituisce un errore localizzato per il campo password.
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());
        // Registra nella sessione il timestamp della conferma password.
        // Laravel usa questo valore per verificare se la conferma è recente.

        return redirect()->intended(route('dashboard', absolute: false));
        // Reindirizza alla pagina desiderata o alla dashboard se non specificato.
    }
}
