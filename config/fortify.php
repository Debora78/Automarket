<?php

/**
 * File di configurazione di Laravel Fortify.
 *
 * Qui vengono definiti:
 * - il guard di autenticazione utilizzato da Fortify
 * - il broker per il reset password
 * - il campo usato come username
 * - il percorso di redirect dopo login/reset
 * - il middleware applicato alle rotte Fortify
 * - i rate limiter per login e 2FA
 * - le funzionalità Fortify abilitate (registrazione, reset password, 2FA, ecc.)
 *
 * Tutti i valori possono essere sovrascritti tramite variabili d’ambiente (.env).
 */

use Laravel\Fortify\Features;
// Classe che permette di abilitare/disabilitare funzionalità Fortify.

return [

    /*
    |--------------------------------------------------------------------------
    | Fortify Guard
    |--------------------------------------------------------------------------
    |
    | Guard di autenticazione utilizzato da Fortify.
    | Deve corrispondere a uno dei guard definiti in config/auth.php.
    |
    */
    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Fortify Password Broker
    |--------------------------------------------------------------------------
    |
    | Broker utilizzato per il reset password.
    | Deve corrispondere a uno dei broker definiti in config/auth.php.
    |
    */
    'passwords' => 'users',

    /*
    |--------------------------------------------------------------------------
    | Username / Email
    |--------------------------------------------------------------------------
    |
    | Campo utilizzato come "username" dell'applicazione.
    | Di default è l'email, ma può essere cambiato (es. 'username').
    |
    | Fortify si aspetta che i form di reset/forgot password
    | contengano un campo chiamato 'email', salvo modifica qui.
    |
    */
    'username' => 'email',

    'email' => 'email',
    // Campo email utilizzato per reset password e autenticazione.

    /*
    |--------------------------------------------------------------------------
    | Lowercase Usernames
    |--------------------------------------------------------------------------
    |
    | Se true, converte automaticamente gli username in minuscolo
    | prima di salvarli nel database.
    |
    */
    'lowercase_usernames' => true,

    /*
    |--------------------------------------------------------------------------
    | Home Path
    |--------------------------------------------------------------------------
    |
    | Percorso verso cui l’utente viene reindirizzato dopo login
    | o reset password completato.
    |
    */
    'home' => '/cars/create',

    /*
    |--------------------------------------------------------------------------
    | Fortify Routes Prefix / Subdomain
    |--------------------------------------------------------------------------
    |
    | Prefisso e dominio per le rotte Fortify.
    | Utile per organizzare le rotte sotto un namespace o subdominio.
    |
    */
    'prefix' => '',

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Fortify Routes Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware applicati alle rotte Fortify.
    | Di default viene usato il middleware 'web'.
    |
    */
    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Rate limiter utilizzati da Fortify per login e 2FA.
    | I limiter sono definiti nel FortifyServiceProvider.
    |
    */
    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    /*
    |--------------------------------------------------------------------------
    | Register View Routes
    |--------------------------------------------------------------------------
    |
    | Se impostato a false, Fortify non registrerà le rotte che restituiscono
    | viste (login, register, ecc.). Utile per SPA o API-only.
    |
    */
    'views' => true,

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | Funzionalità Fortify abilitate.
    | È possibile rimuovere o aggiungere feature a seconda delle necessità.
    |
    */
    'features' => [
        Features::registration(),
        // Abilita la registrazione utenti.

        Features::resetPasswords(),
        // Abilita il reset password.

        // Features::emailVerification(),
        // Abilita la verifica email (disattivata).

        Features::updateProfileInformation(),
        // Permette agli utenti di aggiornare i dati del profilo.

        Features::updatePasswords(),
        // Permette agli utenti di aggiornare la password.

        Features::twoFactorAuthentication([
            'confirm' => true,
            // Richiede conferma prima di abilitare la 2FA.

            'confirmPassword' => true,
            // Richiede conferma password per operazioni sensibili.

            // 'window' => 0,
            // Finestra temporale per codici TOTP (opzionale).
        ]),
    ],

];
