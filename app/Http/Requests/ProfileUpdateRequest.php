<?php
// Apertura del file PHP.

/**
 * Questa Form Request gestisce la validazione dei dati del profilo utente
 * durante l’aggiornamento delle informazioni personali.
 *
 * Si occupa di:
 * - Validare nome ed email
 * - Assicurare che l’email sia univoca, ignorando l’utente corrente
 * - Applicare regole coerenti con gli standard di sicurezza e formattazione
 *
 * È utilizzata dal ProfileController per garantire che i dati aggiornati
 * siano sempre validi e sicuri prima di essere salvati nel database.
 */

namespace App\Http\Requests;
// Namespace che organizza le Form Request dell’applicazione.

use App\Models\User;
// Importa il modello User, necessario per la regola di unicità dell’email.

use Illuminate\Foundation\Http\FormRequest;
// Classe base per creare Form Request personalizzate.

use Illuminate\Validation\Rule;
// Classe che permette di definire regole avanzate di validazione.

class ProfileUpdateRequest extends FormRequest
// Form Request che valida i dati inviati per aggiornare il profilo utente.
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    // Regole di validazione applicate ai dati del profilo.
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            // Il nome è obbligatorio, deve essere una stringa e lungo max 255 caratteri.

            'email' => [
                'required',
                // L’email è obbligatoria.

                'string',
                // Deve essere una stringa.

                'lowercase',
                // Viene convertita automaticamente in minuscolo.

                'email',
                // Deve essere un indirizzo email valido.

                'max:255',
                // Lunghezza massima consentita.

                Rule::unique(User::class)->ignore($this->user()->id),
                // L’email deve essere univoca nella tabella users,
                // ma ignora l’utente corrente per permettere di mantenere la propria email.
            ],
        ];
    }
}
