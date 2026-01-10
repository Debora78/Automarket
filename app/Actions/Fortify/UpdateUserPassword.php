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
            // Avvia la validazione dei dati ricevuti.

            'current_password' => ['required', 'string', 'current_password:web'],
            // 'required' → la password attuale è obbligatoria.
            // 'string'   → deve essere una stringa.
            // 'current_password:web' → verifica automaticamente che la password inserita corrisponda a quella dell'utente loggato.

            'password' => $this->passwordRules(),
            // Applica le regole di validazione della nuova password definite nel trait.
        ], [
            'current_password.current_password' => __('The provided password does not match your current password.'),
            // Messaggio personalizzato mostrato quando la password attuale non è corretta.
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
