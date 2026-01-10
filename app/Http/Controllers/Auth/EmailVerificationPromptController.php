<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce la visualizzazione del prompt di verifica email,
 * utilizzato da Laravel Fortify quando un utente autenticato non ha ancora
 * confermato il proprio indirizzo email.
 *
 * Si occupa di:
 * - Controllare se l’utente ha già verificato l’email
 * - Reindirizzare alla dashboard se la verifica è già stata completata
 * - Mostrare la vista che invita l’utente a verificare l’indirizzo email
 *
 * È un componente essenziale del flusso di verifica email e garantisce
 * che l’utente completi la procedura prima di accedere a sezioni protette.
 */

namespace App\Http\Controllers\Auth;
// Namespace che organizza i controller relativi all'autenticazione.

use App\Http\Controllers\Controller;
// Importa il controller base di Laravel da cui questo controller eredita.

use Illuminate\Http\RedirectResponse;
// Importa la classe per risposte HTTP di tipo redirect.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

use Illuminate\View\View;
// Importa la classe View per tipizzare il metodo che restituisce una vista.

class EmailVerificationPromptController extends Controller
// Definisce il controller che mostra il prompt di verifica email.
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    // Metodo invocabile direttamente come controller single-action.
    {
        return $request->user()->hasVerifiedEmail()
            // Controlla se l’utente ha già verificato l’email.

            ? redirect()->intended(route('dashboard', absolute: false))
            // Se l’email è verificata, reindirizza alla dashboard
            // o alla pagina che l’utente voleva visitare.

            : view('auth.verify-email');
        // Altrimenti mostra la vista che invita l’utente a verificare l’email.
    }
}
