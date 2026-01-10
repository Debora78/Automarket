<?php

/**
 * File di configurazione dell’autenticazione Laravel.
 *
 * Qui vengono definiti:
 * - il guard predefinito (sessione web)
 * - il provider degli utenti (Eloquent)
 * - la configurazione del reset password
 * - i timeout di conferma password
 *
 * Tutte le impostazioni possono essere sovrascritte tramite variabili d’ambiente.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Impostazioni predefinite per:
    | - guard di autenticazione
    | - broker per il reset della password
    |
    | Questi valori possono essere modificati nel file .env.
    |
    */
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        // Guard predefinito: utilizza la sessione web.

        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
        // Broker predefinito per il reset password.
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | I guard definiscono come gli utenti vengono autenticati.
    | Il guard "web" utilizza:
    | - driver "session"
    | - provider "users"
    |
    | È la configurazione standard per applicazioni web.
    |
    */
    'guards' => [
        'web' => [
            'driver' => 'session',
            // Autenticazione basata su sessione.

            'provider' => 'users',
            // Provider che recupera gli utenti dal database.
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | I provider definiscono come gli utenti vengono recuperati dal database.
    | Qui viene utilizzato Eloquent con il modello App\Models\User.
    |
    | È possibile definire provider multipli per gestire più tabelle utenti.
    |
    | Provider supportati: "eloquent", "database"
    |
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            // Usa Eloquent per recuperare gli utenti.

            'model' => env('AUTH_MODEL', App\Models\User::class),
            // Modello Eloquent utilizzato per l’autenticazione.
        ],

        // Esempio alternativo con driver database:
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Configurazione del sistema di reset password.
    | - provider: quale provider utenti utilizzare
    | - table: tabella che contiene i token di reset
    | - expire: minuti di validità del token
    | - throttle: tempo minimo tra richieste successive
    |
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            // Provider associato al reset password.

            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            // Tabella che contiene i token di reset.

            'expire' => 60,
            // Token valido per 60 minuti.

            'throttle' => 60,
            // L’utente può richiedere un nuovo token ogni 60 secondi.
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Tempo (in secondi) prima che venga richiesta nuovamente
    | la conferma della password per operazioni sensibili.
    |
    | Valore predefinito: 10800 secondi (3 ore).
    |
    */
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
