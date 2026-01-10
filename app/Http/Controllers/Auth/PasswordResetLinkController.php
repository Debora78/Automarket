<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce la richiesta di invio del link per il reset
 * della password tramite email, parte del flusso di recupero password
 * gestito da Laravel Fortify.
 *
 * Si occupa di:
 * - Mostrare la pagina in cui l’utente inserisce la propria email
 * - Validare l’indirizzo email fornito
 * - Inviare il link di reset tramite il broker di Laravel
 * - Restituire un messaggio di successo o errore in base all’esito
 *
 * È un componente essenziale del processo di recupero password e garantisce
 * un’esperienza chiara e sicura per l’utente che ha dimenticato le credenziali.
 */

namespace App\Http\Controllers\Auth;
// Namespace che organizza i controller relativi all'autenticazione.

use App\Http\Controllers\Controller;
// Importa il controller base di Laravel da cui questo controller eredita.

use Illuminate\Http\RedirectResponse;
// Importa la classe per risposte HTTP di tipo redirect.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

use Illuminate\Support\Facades\Password;
// Importa la facade Password per inviare il link di reset tramite il broker.

use Illuminate\View\View;
// Importa la classe View per tipizzare il metodo che restituisce una vista.

class PasswordResetLinkController extends Controller
// Definisce il controller che gestisce la richiesta del link di reset password.
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    // Mostra la pagina in cui l’utente inserisce la propria email per ricevere il link.
    {
        return view('auth.forgot-password');
        // Restituisce la vista 'auth.forgot-password'.
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    // Gestisce la richiesta di invio del link di reset password.
    {
        $request->validate([
            // Valida i dati inviati dal form.

            'email' => ['required', 'email'],
            // L’email è obbligatoria e deve essere valida.
        ]);

        // Tentativo di invio del link di reset tramite il broker di Laravel.
        $status = Password::sendResetLink(
            $request->only('email')
            // Passa al broker solo l’email dell’utente.
        );

        // Restituisce una risposta in base all’esito dell’operazione.
        return $status == Password::RESET_LINK_SENT
            // Se il link è stato inviato correttamente:

            ? back()->with('status', __($status))
            // Torna indietro con un messaggio di successo.

            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
        // In caso di errore, torna indietro con l’email precompilata
        // e mostra il messaggio di errore.
    }
}
