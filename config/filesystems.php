<?php

/**
 * File di configurazione del filesystem di Laravel.
 *
 * Qui vengono definiti:
 * - il disco predefinito da utilizzare per lo storage
 * - tutti i dischi disponibili (local, public, s3, ecc.)
 * - i link simbolici creati tramite `php artisan storage:link`
 *
 * Ogni disco rappresenta un driver di storage con impostazioni dedicate.
 * Tutti i valori possono essere sovrascritti tramite variabili d’ambiente (.env).
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Disco di filesystem predefinito utilizzato dall’applicazione.
    | Se non specificato altrove, Laravel userà questo disco.
    |
    */
    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Elenco dei dischi configurabili per lo storage.
    | È possibile definire più dischi anche con lo stesso driver.
    |
    | Driver supportati: "local", "ftp", "sftp", "s3"
    |
    */
    'disks' => [

        'local' => [
            'driver' => 'local',
            // Driver locale basato sul filesystem del server.

            'root' => storage_path('app/private'),
            // Percorso root dei file privati.

            'serve' => true,
            // Permette a Laravel di servire i file tramite route dedicate.

            'throw' => false,
            // Se true, lancia eccezioni in caso di errori.

            'report' => false,
            // Se true, abilita report sugli errori.
        ],

        'public' => [
            'driver' => 'local',
            // Driver locale per file pubblici.

            'root' => storage_path('app/public'),
            // Percorso root dei file pubblici.

            'url' => env('APP_URL') . '/storage',
            // URL pubblico per accedere ai file.

            'visibility' => 'public',
            // I file sono accessibili pubblicamente.

            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            // Driver Amazon S3 per storage cloud.

            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            // Credenziali AWS.

            'region' => env('AWS_DEFAULT_REGION'),
            // Regione AWS.

            'bucket' => env('AWS_BUCKET'),
            // Nome del bucket S3.

            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            // Endpoint personalizzato (opzionale).

            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            // Abilita path-style per compatibilità con servizi S3 compatibili.

            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Link simbolici creati tramite `php artisan storage:link`.
    | La chiave è il percorso del link, il valore è il target reale.
    |
    */
    'links' => [
        public_path('storage') => storage_path('app/public'),
        // Collega "public/storage" alla cartella dei file pubblici.
    ],

];
