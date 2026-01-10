<?php
// Apertura del file PHP.

/**
 * Questa Form Request gestisce la validazione e l’autenticazione
 * della richiesta di login dell’utente.
 *
 * Si occupa di:
 * - Validare email e password
 * - Applicare un sistema di rate limiting per prevenire tentativi eccessivi
 * - Effettuare il tentativo di autenticazione tramite Auth::attempt()
 * - Generare errori personalizzati in caso di credenziali errate o troppi tentativi
 *
 * È un componente fondamentale del flusso di autenticazione e garantisce
 * sicurezza e protezione contro attacchi di brute force.
 */

namespace App\Http\Requests\Auth;
// Namespace dedicato alle Form Request relative all’autenticazione.

use Illuminate\Auth\Events\Lockout;
// Evento lanciato quando un utente supera il limite di tentativi.

use Illuminate\Foundation\Http\FormRequest;
// Classe base per creare Form Request personalizzate.

use Illuminate\Support\Facades\Auth;
// Facade per gestire l’autenticazione.

use Illuminate\Support\Facades\RateLimiter;
// Facade per gestire il rate limiting dei tentativi di login.

use Illuminate\Support\Str;
// Classe helper per manipolare stringhe.

use Illuminate\Validation\ValidationException;
// Eccezione lanciata quando la validazione fallisce.

class LoginRequest extends FormRequest
// Form Request che gestisce validazione e autenticazione del login.
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    // Autorizza sempre la richiesta: chiunque può tentare il login.
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    // Regole di validazione per email e password.
    {
        return [
            'email' => ['required', 'string', 'email'],
            // L’email è obbligatoria e deve essere valida.

            'password' => ['required', 'string'],
            // La password è obbligatoria.
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    // Tenta l’autenticazione dell’utente.
    {
        $this->ensureIsNotRateLimited();
        // Controlla che non siano stati superati i tentativi consentiti.

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Se le credenziali non sono valide:

            RateLimiter::hit($this->throttleKey());
            // Incrementa il contatore dei tentativi falliti.

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
                // Restituisce un messaggio di errore standard.
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        // Se il login ha successo, resetta il contatore dei tentativi.
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    // Verifica che non siano stati superati i tentativi massimi di login.
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            // Se i tentativi NON superano il limite, prosegue normalmente.

            return;
        }

        event(new Lockout($this));
        // Lancia l’evento Lockout per eventuali listener.

        $seconds = RateLimiter::availableIn($this->throttleKey());
        // Calcola quanti secondi mancano allo sblocco.

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
                // Restituisce un messaggio con il tempo di attesa.
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    // Genera una chiave univoca per il rate limiting basata su email + IP.
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
        // Normalizza l’email e concatena l’indirizzo IP.
    }
}
