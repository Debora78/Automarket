<?php
// Apertura del file PHP.

/**
 * Questo trait centralizza le regole di validazione delle password utilizzate
 * da Laravel Fortify durante registrazione, aggiornamento e reset della password.
 *
 * Fornisce un unico metodo riutilizzabile che:
 * - Applica le regole di sicurezza predefinite di Laravel
 * - Richiede la conferma della password tramite il campo password_confirmation
 * - Mantiene la logica di validazione coerente in tutto il progetto
 *
 * L’uso di questo trait garantisce manutenibilità e uniformità nelle policy di sicurezza.
 */

namespace App\Actions\Fortify;
// Definisce il namespace del trait, mantenendo l'organizzazione coerente con le azioni di Fortify.

use Illuminate\Validation\Rules\Password;
// Importa la classe Password, che fornisce regole predefinite e configurabili per la validazione delle password.

trait PasswordValidationRules
// Definizione del trait che conterrà le regole di validazione delle password.
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function passwordRules(): array
    // Metodo protetto che restituisce un array di regole di validazione per la password.
    {
        return ['required', 'string', Password::default(), 'confirmed'];
        // 'required'   → la password è obbligatoria.
        // 'string'     → deve essere una stringa.
        // Password::default() → applica le regole di sicurezza predefinite di Laravel (lunghezza minima, complessità, ecc.).
        // 'confirmed'  → richiede un campo 'password_confirmation' che deve combaciare con 'password'.
    }
}
