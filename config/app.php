<?php

/**
 * File di configurazione principale dell'applicazione Laravel.
 *
 * Contiene tutte le impostazioni fondamentali dell'app:
 * - nome dell'applicazione
 * - ambiente (local, production, ecc.)
 * - debug mode
 * - URL principale
 * - timezone e localizzazione
 * - chiavi di cifratura
 * - configurazione della maintenance mode
 *
 * Tutti i valori possono essere sovrascritti tramite variabili d'ambiente (.env).
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | Nome dell'applicazione, utilizzato in notifiche, email e UI.
    | Se non definito nel file .env, viene usato "Laravel".
    |
    */
    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | Ambiente corrente dell'applicazione: local, staging, production, ecc.
    | Determina il comportamento di vari servizi e configurazioni.
    |
    */
    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | Se attivo, mostra errori dettagliati con stack trace.
    | In produzione deve essere sempre disattivato.
    |
    */
    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | URL principale dell'applicazione, usato da Artisan e da vari servizi.
    | Deve corrispondere alla root del progetto.
    |
    */
    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Timezone predefinita dell'applicazione.
    | Usata da PHP e Carbon per gestire date e orari.
    |
    */
    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | Locale predefinita per traduzioni e localizzazione.
    | fallback_locale viene usata se la locale principale non è disponibile.
    |
    */
    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),
    // Locale usata da Faker per generare dati fake.

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | Chiave usata per cifrare dati sensibili.
    | Deve essere lunga 32 caratteri e impostata nel file .env.
    |
    */
    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],
    // Chiavi precedenti usate per decifrare dati storici.

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | Configurazione del sistema di maintenance mode.
    | Può essere gestito tramite file locale o tramite cache distribuita.
    |
    | Driver supportati: "file", "cache"
    |
    */
    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        // Driver usato per attivare/disattivare la maintenance mode.

        'store' => env('APP_MAINTENANCE_STORE', 'database'),
        // Store usato quando il driver è "cache".
    ],

];
