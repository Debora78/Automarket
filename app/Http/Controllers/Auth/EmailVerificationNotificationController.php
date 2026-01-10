<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce l’invio della notifica di verifica email
 * per gli utenti che non hanno ancora confermato il proprio indirizzo.
 *
 * Si occupa di:
 * - Controllare se l’utente ha già verificato l’email
 * - Inviare una nuova email di verifica quando necessario
 * - Restituire un feedback alla vista tramite sessione
 *
 * È un componente fondamentale del flusso di verifica email di Laravel Fortify
 * e garantisce che l’utente possa completare correttamente la procedura
 * di attivazione del proprio account.
 */

namespace App\Http\Controllers\Auth;
// Namespace che organizza i controller relativi all'autenticazione.

use App\Http\Controllers\Controller;
// Importa il controller base di Laravel da cui questo controller eredita.

use Illuminate\Http\RedirectResponse;
// Importa la classe per risposte HTTP di tipo redirect.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

class EmailVerificationNotificationController extends Controller
// Definisce il controller che gestisce l'invio della notifica di verifica email.
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    // Metodo che invia una nuova email di verifica all'utente.
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Se l'utente ha già verificato l'email:

            return redirect()->intended(route('dashboard', absolute: false));
            // Reindirizza alla dashboard o alla pagina desiderata.
        }

        $request->user()->sendEmailVerificationNotification();
        // Invia una nuova email di verifica all'utente.

        return back()->with('status', 'verification-link-sent');
        // Torna alla pagina precedente con un messaggio di stato
        // che indica che il link è stato inviato correttamente.
    }
}
