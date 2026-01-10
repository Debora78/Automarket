<?php

/**
 * File di configurazione del database per l’applicazione Laravel.
 *
 * Qui vengono definiti:
 * - la connessione database predefinita
 * - tutte le connessioni disponibili (SQLite, MySQL, MariaDB, PostgreSQL, SQL Server)
 * - la tabella delle migrazioni
 * - la configurazione di Redis
 *
 * Tutti i valori possono essere sovrascritti tramite variabili d’ambiente (.env).
 */

use Illuminate\Support\Str;
// Helper per manipolare stringhe, usato per generare prefissi Redis.

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Connessione database predefinita utilizzata dall’applicazione.
    | Se non specificato altrove, Laravel userà questa connessione.
    |
    */
    'default' => env('DB_CONNECTION', 'sqlite'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Elenco di tutte le connessioni database disponibili.
    | Ogni connessione può essere configurata tramite variabili d’ambiente.
    |
    */
    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            // Driver SQLite.

            'url' => env('DB_URL'),
            // URL di connessione (opzionale).

            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            // Percorso del file SQLite.

            'prefix' => '',
            // Prefisso tabelle.

            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            // Abilita vincoli FK.

            'busy_timeout' => null,
            'journal_mode' => null,
            'synchronous' => null,
            'transaction_mode' => 'DEFERRED',
            // Opzioni avanzate SQLite.
        ],

        'mysql' => [
            'driver' => 'mysql',
            // Driver MySQL.

            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),

            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),

            'prefix' => '',
            'prefix_indexes' => true,

            'strict' => true,
            // Modalità strict per query più sicure.

            'engine' => null,
            // Motore MySQL (InnoDB, MyISAM, ecc.).

            'options' => extension_loaded('pdo_mysql') ? array_filter([
                (PHP_VERSION_ID >= 80500 ? \Pdo\Mysql::ATTR_SSL_CA : \PDO::MYSQL_ATTR_SSL_CA)
                => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
            // Opzioni SSL.
        ],

        'mariadb' => [
            'driver' => 'mariadb',
            // Driver MariaDB.

            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),

            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),

            'prefix' => '',
            'prefix_indexes' => true,

            'strict' => true,
            'engine' => null,

            'options' => extension_loaded('pdo_mysql') ? array_filter([
                (PHP_VERSION_ID >= 80500 ? \Pdo\Mysql::ATTR_SSL_CA : \PDO::MYSQL_ATTR_SSL_CA)
                => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            // Driver PostgreSQL.

            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),

            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,

            'search_path' => 'public',
            // Schema predefinito.

            'sslmode' => 'prefer',
            // Modalità SSL.
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            // Driver SQL Server.

            'url' => env('DB_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),

            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,

            // Opzioni SSL commentate:
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | Tabella che tiene traccia delle migrazioni già eseguite.
    |
    */
    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Configurazione delle connessioni Redis.
    | Redis è un archivio key-value molto veloce e avanzato.
    |
    */
    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),
        // Client Redis utilizzato.

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            // Modalità cluster.

            'prefix' => env(
                'REDIS_PREFIX',
                Str::slug((string) env('APP_NAME', 'laravel')) . '-database-'
            ),
            // Prefisso chiavi Redis.

            'persistent' => env('REDIS_PERSISTENT', false),
            // Connessione persistente.
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),

            'max_retries' => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base' => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap' => env('REDIS_BACKOFF_CAP', 1000),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),

            'max_retries' => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base' => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap' => env('REDIS_BACKOFF_CAP', 1000),
        ],

    ],

];
