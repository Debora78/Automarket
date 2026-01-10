<?php

/**
 * File di configurazione delle code (queue) di Laravel.
 *
 * Qui vengono definiti:
 * - la connessione di coda predefinita
 * - tutte le connessioni disponibili (database, redis, sqs, ecc.)
 * - la configurazione del job batching
 * - la gestione dei job falliti
 *
 * Laravel fornisce un sistema unificato per gestire code asincrone,
 * permettendo di delegare lavori pesanti o differiti a vari backend.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    |
    | Connessione di coda predefinita utilizzata dall’applicazione.
    | Se non specificato altrove, Laravel userà questa connessione.
    |
    */
    'default' => env('QUEUE_CONNECTION', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Elenco delle connessioni disponibili per le code.
    | Ogni connessione utilizza un driver differente.
    |
    | Driver supportati:
    | "sync", "database", "beanstalkd", "sqs", "redis",
    | "deferred", "background", "failover", "null"
    |
    */
    'connections' => [

        'sync' => [
            'driver' => 'sync',
            // Esegue i job immediatamente, senza coda.
        ],

        'database' => [
            'driver' => 'database',
            // Usa una tabella del database per gestire i job.

            'connection' => env('DB_QUEUE_CONNECTION'),
            // Connessione database dedicata (opzionale).

            'table' => env('DB_QUEUE_TABLE', 'jobs'),
            // Tabella che contiene i job in coda.

            'queue' => env('DB_QUEUE', 'default'),
            // Nome della coda.

            'retry_after' => (int) env('DB_QUEUE_RETRY_AFTER', 90),
            // Tempo dopo il quale un job può essere ritentato.

            'after_commit' => false,
            // Se true, esegue i job solo dopo commit DB.
        ],

        'beanstalkd' => [
            'driver' => 'beanstalkd',
            // Usa il sistema Beanstalkd.

            'host' => env('BEANSTALKD_QUEUE_HOST', 'localhost'),
            'queue' => env('BEANSTALKD_QUEUE', 'default'),

            'retry_after' => (int) env('BEANSTALKD_QUEUE_RETRY_AFTER', 90),
            'block_for' => 0,
            'after_commit' => false,
        ],

        'sqs' => [
            'driver' => 'sqs',
            // Usa Amazon SQS come backend di coda.

            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),

            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            // URL base SQS.

            'queue' => env('SQS_QUEUE', 'default'),
            'suffix' => env('SQS_SUFFIX'),

            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'after_commit' => false,
        ],

        'redis' => [
            'driver' => 'redis',
            // Usa Redis per gestire le code.

            'connection' => env('REDIS_QUEUE_CONNECTION', 'default'),
            // Connessione Redis dedicata.

            'queue' => env('REDIS_QUEUE', 'default'),
            // Nome della coda.

            'retry_after' => (int) env('REDIS_QUEUE_RETRY_AFTER', 90),
            'block_for' => null,
            'after_commit' => false,
        ],

        'deferred' => [
            'driver' => 'deferred',
            // Driver speciale per job differiti.
        ],

        'background' => [
            'driver' => 'background',
            // Driver per job eseguiti in background.
        ],

        'failover' => [
            'driver' => 'failover',
            // Usa più connessioni in fallback.

            'connections' => [
                'database',
                'deferred',
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Job Batching
    |--------------------------------------------------------------------------
    |
    | Configurazione per il batching dei job.
    | I batch permettono di raggruppare più job e monitorarli insieme.
    |
    */
    'batching' => [
        'database' => env('DB_CONNECTION', 'sqlite'),
        // Connessione database usata per i batch.

        'table' => 'job_batches',
        // Tabella che contiene i batch.
    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | Configurazione per la gestione dei job falliti.
    | Laravel può salvarli su file, database o DynamoDB.
    |
    | Driver supportati:
    | "database-uuids", "dynamodb", "file", "null"
    |
    */
    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        // Driver usato per salvare i job falliti.

        'database' => env('DB_CONNECTION', 'sqlite'),
        // Connessione database.

        'table' => 'failed_jobs',
        // Tabella che contiene i job falliti.
    ],

];
