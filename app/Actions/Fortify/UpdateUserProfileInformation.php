<?php
// Apertura del file PHP.

/**
 * Questa classe gestisce l’aggiornamento delle informazioni del profilo utente
 * all’interno del flusso di gestione account di Laravel Fortify.
 *
 * Si occupa di:
 * - Validare i dati del profilo (nome ed email) con regole coerenti e sicure
 * - Verificare l’unicità dell’email ignorando l’utente corrente
 * - Gestire correttamente il caso in cui l’utente cambi email e debba
 *   nuovamente verificarla (solo se implementa MustVerifyEmail)
 * - Aggiornare i dati nel database tramite forceFill in modo controllato
 *
 * È un componente essenziale della sezione “Profilo” e garantisce che
 * le informazioni dell’utente vengano aggiornate in modo sicuro,
 * coerente e conforme alle policy di verifica email del sistema.
 */

namespace App\Actions\Fortify;
// Namespace che organizza le azioni utilizzate da Laravel Fortify.

use App\Models\User;
// Importa il modello User, necessario per aggiornare i dati del profilo.

use Illuminate\Contracts\Auth\MustVerifyEmail;
// Importa l'interfaccia che indica se l'utente richiede la verifica email.

use Illuminate\Support\Facades\Validator;
// Importa la facade Validator per validare i dati inviati dal form.

use Illuminate\Validation\Rule;
// Importa la classe Rule per definire regole avanzate (es. email univoca ignorando l'utente corrente).

use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
// Importa il contratto che questa classe deve implementare per integrarsi con Fortify.

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
// Definisce la classe che gestisce l'aggiornamento delle informazioni del profilo utente.
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    // Metodo pubblico che riceve l'utente e i dati del form, e aggiorna il profilo.
    {
        Validator::make($input, [
            // Avvia la validazione dei dati ricevuti.

            'name' => ['required', 'string', 'max:255'],
            // Il nome è obbligatorio, deve essere una stringa e lungo massimo 255 caratteri.

            'email' => [
                'required',
                // L'email è obbligatoria.

                'string',
                // Deve essere una stringa.

                'email',
                // Deve essere un indirizzo email valido.

                'max:255',
                // Lunghezza massima 255 caratteri.

                Rule::unique('users')->ignore($user->id),
                // L'email deve essere unica nella tabella users,
                // ma ignora l'utente corrente per evitare falsi positivi.
            ],
        ])->validateWithBag('updateProfileInformation');
        // Esegue la validazione e inserisce eventuali errori nella bag 'updateProfileInformation'.

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            // Se l'utente ha cambiato email e richiede la verifica email,
            // viene avviata la procedura di reset della verifica.

            $this->updateVerifiedUser($user, $input);
            // Aggiorna i dati e resetta la verifica email.
        } else {
            // Se l'email non è cambiata o l'utente non richiede verifica email:

            $user->forceFill([
                // Aggiorna i campi ignorando i fillable (sicuro perché controllato manualmente).

                'name' => $input['name'],
                // Aggiorna il nome.

                'email' => $input['email'],
                // Aggiorna l'email.
            ])->save();
            // Salva le modifiche nel database.
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    // Metodo protetto che gestisce l'aggiornamento del profilo per utenti che devono verificare l'email.
    {
        $user->forceFill([
            // Aggiorna i campi ignorando i fillable.

            'name' => $input['name'],
            // Aggiorna il nome.

            'email' => $input['email'],
            // Aggiorna l'email.

            'email_verified_at' => null,
            // Reset della verifica email: l'utente dovrà confermare il nuovo indirizzo.
        ])->save();
        // Salva le modifiche nel database.

        $user->sendEmailVerificationNotification();
        // Invia automaticamente una nuova email di verifica.
    }
}
