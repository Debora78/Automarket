<?php

/**
 * File di configurazione delle sessioni in Laravel.
 *
 * Qui vengono definiti:
 * - il driver di sessione predefinito
 * - la durata della sessione
 * - la gestione dei cookie di sessione
 * - la configurazione per database, file o cache
 * - le impostazioni di sicurezza (SameSite, HTTPS, HttpOnly)
 *
 * Le sessioni permettono di mantenere lo stato tra richieste HTTP,
 * e questo file controlla come e dove tali dati vengono salvati.
 */

use Illuminate\Support\Str;
// Helper per generare stringhe, usato per il nome del cookie.

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | Driver di sessione predefinito utilizzato dall’applicazione.
    | Laravel supporta diversi sistemi di storage per le sessioni.
    |
    | Driver supportati:
    | "file", "cookie", "database", "memcached",
    | "redis", "dynamodb", "array"
    |
    */
    'driver' => env('SESSION_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Durata della sessione in minuti.
    | Se expire_on_close è true, la sessione scade alla chiusura del browser.
    |
    */
    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),
    // Se true, la sessione termina quando il browser viene chiuso.

    /*
    |--------------------------------------------------------------------------
    | Session Encryption
    |--------------------------------------------------------------------------
    |
    | Se true, tutti i dati della sessione vengono criptati automaticamente.
    |
    */
    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | Session File Location
    |--------------------------------------------------------------------------
    |
    | Percorso dei file di sessione quando si usa il driver "file".
    |
    */
    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    |
    | Connessione database da usare per le sessioni
    | quando si utilizza il driver "database" o "redis".
    |
    */
    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | Tabella utilizzata per salvare le sessioni
    | quando si usa il driver "database".
    |
    */
    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | Store della cache da usare per le sessioni
    | quando si utilizza un driver basato su cache.
    |
    | Riguarda: "dynamodb", "memcached", "redis"
    |
    */
    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Probabilità che Laravel pulisca le sessioni scadute.
    | Valore predefinito: 2 su 100.
    |
    */
    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Nome del cookie di sessione.
    | Di default viene generato a partire dal nome dell’app.
    |
    */
    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'laravel')) . '-session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    |
    | Percorso per cui il cookie è valido.
    | Di solito è la root dell’applicazione.
    |
    */
    'path' => env('SESSION_PATH', '/'),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Domain
    |--------------------------------------------------------------------------
    |
    | Dominio per cui il cookie è valido.
    | Utile per condividere sessioni tra sottodomini.
    |
    */
    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | HTTPS Only Cookies
    |--------------------------------------------------------------------------
    |
    | Se true, il cookie viene inviato solo tramite connessioni HTTPS.
    |
    */
    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Access Only
    |--------------------------------------------------------------------------
    |
    | Se true, JavaScript non può accedere al cookie (HttpOnly).
    | Migliora la sicurezza contro attacchi XSS.
    |
    */
    'http_only' => env('SESSION_HTTP_ONLY', true),

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | Controlla il comportamento del cookie in richieste cross-site.
    | Valori supportati: "lax", "strict", "none", null
    |
    */
    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
    | Partitioned Cookies
    |--------------------------------------------------------------------------
    |
    | Se true, abilita cookie partizionati per contesti cross-site.
    | Richiede secure=true e SameSite="none".
    |
    */
    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];
