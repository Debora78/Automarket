<?php
// Apertura del file PHP.



/**
 * Questa classe gestisce l’aggiornamento della password dell’utente autenticato
 * all’interno del flusso di sicurezza di Laravel Fortify.
 *
 * Si occupa di:
 * - Validare la password attuale tramite la regola `current_password:web`
 * - Applicare le regole di sicurezza definite nel trait PasswordValidationRules
 * - Aggiornare la password dell’utente nel database tramite hashing sicuro
 *
 * Viene utilizzata nella sezione “Profilo” o “Impostazioni account” per permettere
 * all’utente di modificare la propria password mantenendo un elevato livello di sicurezza.
 */

namespace App\Actions\Fortify;
// Namespace che organizza le azioni utilizzate da Laravel Fortify.

use App\Models\User;
// Importa il modello User, necessario per aggiornare la password dell'utente autenticato.

use Illuminate\Support\Facades\Hash;
// Importa la facade Hash per criptare la nuova password.

use Illuminate\Support\Facades\Validator;
// Importa la facade Validator per validare i dati inviati dal form di aggiornamento.

use Laravel\Fortify\Contracts\UpdatesUserPasswords;
// Importa il contratto che questa classe deve implementare per integrarsi con Fortify.



class UpdateUserPassword implements UpdatesUserPasswords
// Definisce la classe che gestisce la logica di aggiornamento della password dell'utente.
{
    use PasswordValidationRules;
    // Include il trait che contiene le regole di validazione della password.

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    // Metodo pubblico che riceve l'utente autenticato e i dati del form, e aggiorna la password.
    {
        Validator::make($input, [

            'current_password' => ['required', 'string', 'current_password:web'],

            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',      // almeno una minuscola
                'regex:/[A-Z]/',      // almeno una maiuscola
                'regex:/[0-9]/',      // almeno un numero
                'regex:/[@$!%*#?&]/', // almeno un carattere speciale
                'confirmed',
            ],

        ], [
            'current_password.current_password' => __('The provided password does not match your current password.'),
            'password.regex' => __('The password must contain at least one uppercase letter, one lowercase letter, one number and one special character.'),
        ])->validateWithBag('updatePassword');

        // Valida i dati e, in caso di errore, inserisce i messaggi nella bag 'updatePassword'.

        $user->forceFill([
            // Aggiorna i campi dell'utente ignorando i fillable (sicuro perché controllato manualmente).

            'password' => Hash::make($input['password']),
            // Cripta la nuova password prima di salvarla nel database.
        ])->save();
        // Salva le modifiche nel database.
    }
}
