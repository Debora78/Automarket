<?php
// Apertura del file PHP.

/**
 * Questa classe gestisce il reset della password dimenticata da parte dell’utente
 * all’interno del flusso di recupero password di Laravel Fortify.
 *
 * Si occupa di:
 * - Validare la nuova password tramite il trait PasswordValidationRules
 * - Aggiornare la password dell’utente nel database in modo sicuro tramite hashing
 * - Utilizzare forceFill per aggiornare il campo protetto in modo controllato
 *
 * È un elemento essenziale del processo di recupero password e garantisce
 * che l’aggiornamento avvenga in modo sicuro e conforme alle policy del sistema.
 */

namespace App\Actions\Fortify;
// Namespace che organizza le azioni utilizzate da Laravel Fortify.

use App\Models\User;
// Importa il modello User, necessario per aggiornare la password dell'utente.

use Illuminate\Support\Facades\Hash;
// Importa la facade Hash per criptare la nuova password.

use Illuminate\Support\Facades\Validator;
// Importa la facade Validator per validare i dati inviati dal form di reset.

use Laravel\Fortify\Contracts\ResetsUserPasswords;
// Importa il contratto che questa classe deve implementare per integrarsi con Fortify.

class ResetUserPassword implements ResetsUserPasswords
// Definisce la classe che gestisce la logica di reset della password.
{
    use PasswordValidationRules;
    // Include il trait che contiene le regole di validazione della password.

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  array<string, string>  $input
     */
    public function reset(User $user, array $input): void
    // Metodo pubblico che riceve l'utente e i dati del form, e aggiorna la password.
    {
        Validator::make($input, [
            // Avvia la validazione dei dati ricevuti.

            'password' => $this->passwordRules(),
            // Applica le regole di validazione della password definite nel trait.
        ])->validate();
        // Esegue la validazione e lancia automaticamente un errore se fallisce.

        $user->forceFill([
            // Aggiorna i campi dell'utente ignorando i fillable (sicuro perché controllato manualmente).

            'password' => Hash::make($input['password']),
            // Cripta la nuova password prima di salvarla nel database.
        ])->save();
        // Salva le modifiche nel database.
    }
}
