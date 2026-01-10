<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce la verifica dell’indirizzo email dell’utente
 * autenticato tramite il link inviato da Laravel Fortify.
 *
 * Si occupa di:
 * - Controllare se l’email è già stata verificata
 * - Segnare l’email come verificata quando il link è valido
 * - Dispatchare l’evento Verified per eventuali listener
 * - Reindirizzare l’utente alla dashboard con un parametro di conferma
 *
 * È un componente essenziale del flusso di verifica email e garantisce
 * che l’utente completi correttamente la procedura prima di accedere
 * a funzionalità che richiedono un account verificato.
 */

namespace App\Http\Controllers\Auth;
// Namespace che organizza i controller relativi all'autenticazione.

use App\Http\Controllers\Controller;
// Importa il controller base di Laravel da cui questo controller eredita.

use Illuminate\Auth\Events\Verified;
// Importa l’evento Verified, dispatchato quando l’email viene verificata.

use Illuminate\Foundation\Auth\EmailVerificationRequest;
// Importa la request speciale che valida automaticamente il link di verifica.

use Illuminate\Http\RedirectResponse;
// Importa la classe per risposte HTTP di tipo redirect.

class VerifyEmailController extends Controller
// Definisce il controller che gestisce la verifica dell’email dell’utente.
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    // Metodo invocabile direttamente come controller single-action.
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Se l’utente ha già verificato l’email:

            return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
            // Reindirizza alla dashboard con parametro di conferma.
        }

        if ($request->user()->markEmailAsVerified()) {
            // Se l’email viene verificata correttamente:

            event(new Verified($request->user()));
            // Dispatcha l’evento Verified per eventuali listener (es. log, notifiche).
        }

        return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
        // Reindirizza comunque alla dashboard con parametro di conferma.
    }
}
