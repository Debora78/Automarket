<?php
// Apertura del file PHP

/**
 * Questa classe gestisce la creazione di un nuovo utente tramite Laravel Fortify.
 *
 * Si occupa di:
 * - Validare i dati inviati dal form di registrazione
 * - Applicare le regole di sicurezza per la password tramite il trait PasswordValidationRules
 * - Creare un nuovo record nella tabella users
 * - Impostare automaticamente il ruolo predefinito dell’utente come "user"
 *
 * È un componente fondamentale del flusso di registrazione e garantisce
 * coerenza e sicurezza nella creazione degli account.
 */

namespace App\Actions\Fortify;
// Definisce il namespace in cui si trova questa classe, seguendo la struttura di Laravel Fortify.

use App\Models\User;
// Importa il modello User, necessario per creare un nuovo utente nel database.

use Illuminate\Support\Facades\Hash;
// Importa la facade Hash per criptare la password prima di salvarla.

use Illuminate\Support\Facades\Validator;
// Importa la facade Validator per validare i dati in ingresso.

use Illuminate\Validation\Rule;
// Importa la classe Rule per definire regole di validazione avanzate (es. email univoca).

use Laravel\Fortify\Contracts\CreatesNewUsers;
// Importa il contratto che questa classe deve implementare per integrarsi con Fortify.

class CreateNewUser implements CreatesNewUsers
// Definisce la classe che gestisce la creazione di un nuovo utente e implementa l'interfaccia richiesta da Fortify.
{
    use PasswordValidationRules;
    // Usa un trait fornito da Fortify che contiene le regole di validazione della password.

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    // Metodo pubblico che riceve i dati del form e restituisce un'istanza User appena creata.
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

                Rule::unique(User::class),
                // L'email deve essere unica nella tabella users.
            ],

            'password' => $this->passwordRules(),
            // Applica le regole di validazione della password definite nel trait PasswordValidationRules.
        ])->validate();
        // Esegue la validazione e lancia un errore automatico se fallisce.

        return User::create([
            // Se la validazione è ok, crea un nuovo utente nel database.

            'name' => $input['name'],
            // Assegna il nome inviato dal form.

            'email' => $input['email'],
            // Assegna l'email inviata dal form.

            'password' => Hash::make($input['password']),
            // Cripta la password prima di salvarla per sicurezza.

            'role' => 'user',
            // Imposta il ruolo predefinito dell'utente come "user".
        ]);
    }
}
