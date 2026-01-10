<?php

/**
 * File di configurazione della cache dell’applicazione.
 *
 * Qui vengono definiti:
 * - lo store di cache predefinito
 * - tutti i driver di cache disponibili (file, database, redis, ecc.)
 * - le impostazioni per ciascuno store
 * - il prefisso delle chiavi per evitare collisioni
 *
 * Tutti i valori possono essere sovrascritti tramite variabili d’ambiente (.env).
 */

use Illuminate\Support\Str;
// Helper per manipolare stringhe, usato per generare il prefisso cache.

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | Store di cache predefinito utilizzato dall’applicazione.
    | Se non specificato altrove, Laravel userà questo store.
    |
    */
    'default' => env('CACHE_STORE', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Definizione di tutti gli store di cache disponibili.
    | Ogni store utilizza un driver diverso (file, redis, database, ecc.).
    |
    | È possibile definire più store per lo stesso driver.
    |
    | Driver supportati:
    | "array", "database", "file", "memcached",
    | "redis", "dynamodb", "octane",
    | "failover", "null"
    |
    */
    'stores' => [

        'array' => [
            'driver' => 'array',
            // Cache in memoria volatile (non persistente).

            'serialize' => false,
            // Evita la serializzazione per maggiore velocità.
        ],

        'database' => [
            'driver' => 'database',
            // Usa una tabella del database per salvare la cache.

            'connection' => env('DB_CACHE_CONNECTION'),
            // Connessione database dedicata (opzionale).

            'table' => env('DB_CACHE_TABLE', 'cache'),
            // Tabella che contiene le chiavi di cache.

            'lock_connection' => env('DB_CACHE_LOCK_CONNECTION'),
            // Connessione per i lock (opzionale).

            'lock_table' => env('DB_CACHE_LOCK_TABLE'),
            // Tabella per i lock (opzionale).
        ],

        'file' => [
            'driver' => 'file',
            // Salva la cache su file nel filesystem.

            'path' => storage_path('framework/cache/data'),
            // Percorso dei file di cache.

            'lock_path' => storage_path('framework/cache/data'),
            // Percorso dei file di lock.
        ],

        'memcached' => [
            'driver' => 'memcached',
            // Driver Memcached (richiede estensione PHP).

            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            // ID per connessioni persistenti.

            'sasl' => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            // Credenziali SASL (opzionali).

            'options' => [
                // Opzioni aggiuntive Memcached.
            ],

            'servers' => [
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                    // Host del server Memcached.

                    'port' => env('MEMCACHED_PORT', 11211),
                    // Porta predefinita.

                    'weight' => 100,
                    // Peso del server nel bilanciamento.
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            // Usa Redis come store di cache.

            'connection' => env('REDIS_CACHE_CONNECTION', 'cache'),
            // Connessione Redis dedicata.

            'lock_connection' => env('REDIS_CACHE_LOCK_CONNECTION', 'default'),
            // Connessione per i lock.
        ],

        'dynamodb' => [
            'driver' => 'dynamodb',
            // Usa DynamoDB (AWS) come store di cache.

            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            // Credenziali e regione AWS.

            'table' => env('DYNAMODB_CACHE_TABLE', 'cache'),
            // Tabella DynamoDB per la cache.

            'endpoint' => env('DYNAMODB_ENDPOINT'),
            // Endpoint personalizzato (opzionale).
        ],

        'octane' => [
            'driver' => 'octane',
            // Store ottimizzato per Laravel Octane.
        ],

        'failover' => [
            'driver' => 'failover',
            // Store che usa fallback automatico.

            'stores' => [
                'database',
                'array',
            ],
            // Se il primo store fallisce, usa il successivo.
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | Prefisso per tutte le chiavi di cache.
    | Utile quando più applicazioni condividono lo stesso store.
    |
    */
    'prefix' => env(
        'CACHE_PREFIX',
        Str::slug((string) env('APP_NAME', 'laravel')) . '-cache-'
    ),

];
