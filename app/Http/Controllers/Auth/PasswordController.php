<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce l’aggiornamento della password dell’utente
 * autenticato all’interno della sezione “Profilo” o “Impostazioni account”.
 *
 * Si occupa di:
 * - Validare la password attuale tramite la regola `current_password`
 * - Applicare le regole di sicurezza predefinite per la nuova password
 * - Aggiornare la password dell’utente in modo sicuro tramite hashing
 * - Restituire un feedback alla vista tramite messaggi di stato
 *
 * È un componente essenziale del flusso di gestione account e garantisce
 * che l’utente possa modificare la propria password in modo sicuro e conforme
 * alle policy di autenticazione dell’applicazione.
 */

namespace App\Http\Controllers\Auth;
// Namespace che organizza i controller relativi all'autenticazione.

use App\Http\Controllers\Controller;
// Importa il controller base di Laravel da cui questo controller eredita.

use Illuminate\Http\RedirectResponse;
// Importa la classe per risposte HTTP di tipo redirect.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

use Illuminate\Support\Facades\Hash;
// Importa la facade Hash per criptare la nuova password.

use Illuminate\Validation\Rules\Password;
// Importa le regole di validazione della password (policy di sicurezza).

class PasswordController extends Controller
// Definisce il controller che gestisce l’aggiornamento della password dell’utente autenticato.
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    // Metodo che gestisce la richiesta di aggiornamento della password.
    {
        $validated = $request->validateWithBag('updatePassword', [
            // Valida i dati inviati dal form e inserisce eventuali errori nella bag 'updatePassword'.

            'current_password' => ['required', 'current_password'],
            // 'required' → la password attuale è obbligatoria.
            // 'current_password' → verifica automaticamente che la password inserita
            //                      corrisponda a quella dell’utente autenticato.

            'password' => ['required', Password::defaults(), 'confirmed'],
            // 'required' → la nuova password è obbligatoria.
            // Password::defaults() → applica le regole di sicurezza predefinite di Laravel.
            // 'confirmed' → richiede il campo password_confirmation.
        ]);

        $request->user()->update([
            // Aggiorna i dati dell’utente autenticato.

            'password' => Hash::make($validated['password']),
            // Cripta la nuova password prima di salvarla nel database.
        ]);

        return back()->with('status', 'password-updated');
        // Torna alla pagina precedente con un messaggio di stato che indica
        // che la password è stata aggiornata correttamente.
    }
}
