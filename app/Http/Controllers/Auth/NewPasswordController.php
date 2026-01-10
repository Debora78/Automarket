<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce l’intero flusso di reset della password
 * tramite il link inviato via email da Laravel Fortify.
 *
 * Si occupa di:
 * - Mostrare la pagina in cui l’utente può inserire la nuova password
 * - Validare token, email e password secondo le regole di sicurezza
 * - Effettuare il reset della password tramite il broker di Laravel
 * - Aggiornare la password dell’utente in modo sicuro tramite hashing
 * - Rigenerare il remember_token e dispatchare l’evento PasswordReset
 *
 * È un componente fondamentale del processo di recupero password e garantisce
 * che l’operazione avvenga in modo sicuro, affidabile e conforme alle policy
 * di autenticazione dell’applicazione.
 */

namespace App\Http\Controllers\Auth;
// Namespace che organizza i controller relativi all'autenticazione.

use App\Http\Controllers\Controller;
// Importa il controller base di Laravel da cui questo controller eredita.

use App\Models\User;
// Importa il modello User, necessario per aggiornare la password.

use Illuminate\Auth\Events\PasswordReset;
// Importa l’evento che verrà dispatchato dopo il reset della password.

use Illuminate\Http\RedirectResponse;
// Importa la classe per risposte HTTP di tipo redirect.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

use Illuminate\Support\Facades\Hash;
// Importa la facade Hash per criptare la nuova password.

use Illuminate\Support\Facades\Password;
// Importa la facade Password per gestire il reset tramite il broker.

use Illuminate\Support\Str;
// Importa Str per generare un nuovo remember_token.

use Illuminate\Validation\Rules;
// Importa le regole di validazione, incluse quelle per la password.

use Illuminate\View\View;
// Importa la classe View per tipizzare il metodo che restituisce una vista.

class NewPasswordController extends Controller
// Definisce il controller che gestisce il reset della password tramite link email.
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    // Mostra la pagina in cui l’utente può inserire la nuova password.
    {
        return view('auth.reset-password', ['request' => $request]);
        // Restituisce la vista passando la request (necessaria per token e email).
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    // Gestisce la richiesta di reset della password.
    {
        $request->validate([
            // Valida i dati inviati dal form.

            'token' => ['required'],
            // Il token del reset è obbligatorio.

            'email' => ['required', 'email'],
            // L’email è obbligatoria e deve essere valida.

            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // La password deve rispettare le regole di sicurezza predefinite
            // e deve essere confermata tramite password_confirmation.
        ]);

        // Tentativo di reset della password tramite il broker di Laravel.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            // Passa al broker i dati necessari.

            function (User $user) use ($request) {
                // Callback eseguita se il reset ha successo.

                $user->forceFill([
                    'password' => Hash::make($request->password),
                    // Cripta la nuova password.

                    'remember_token' => Str::random(60),
                    // Rigenera il remember_token per sicurezza.
                ])->save();
                // Salva le modifiche nel database.

                event(new PasswordReset($user));
                // Dispatcha l’evento PasswordReset.
            }
        );

        // Gestione della risposta in base all'esito del reset.
        return $status == Password::PASSWORD_RESET
            // Se il reset è avvenuto con successo:

            ? redirect()->route('login')->with('status', __($status))
            // Reindirizza al login con messaggio di successo.

            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
        // In caso di errore, torna indietro con l’email precompilata
        // e mostra il messaggio di errore.
    }
}
