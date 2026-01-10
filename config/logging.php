<?php

/**
 * File di configurazione del logging per l’applicazione Laravel.
 *
 * Qui vengono definiti:
 * - il canale di log predefinito
 * - il canale dedicato ai messaggi di deprecazione
 * - tutti i canali di log disponibili (single, daily, slack, syslog, ecc.)
 *
 * Laravel utilizza Monolog come motore di logging, permettendo
 * l’uso di numerosi handler e formattatori avanzati.
 */

use Monolog\Handler\NullHandler;
// Handler che scarta completamente i log (utile per silenziare output).

use Monolog\Handler\StreamHandler;
// Handler che scrive i log su un flusso (es. file, stderr).

use Monolog\Handler\SyslogUdpHandler;
// Handler che invia log a un server Syslog via UDP.

use Monolog\Processor\PsrLogMessageProcessor;
// Processor che formatta i messaggi secondo lo standard PSR-3.

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | Canale di log predefinito utilizzato dall’applicazione.
    | Deve corrispondere a uno dei canali definiti nella sezione "channels".
    |
    */
    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | Canale utilizzato per registrare avvisi relativi a funzionalità
    | deprecate di PHP o librerie. Utile per prepararsi a future versioni.
    |
    */
    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        // Canale dedicato ai messaggi di deprecazione.

        'trace' => env('LOG_DEPRECATIONS_TRACE', false),
        // Se true, include il trace dello stack.
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Elenco dei canali di log disponibili.
    | Ogni canale può utilizzare driver diversi e configurazioni personalizzate.
    |
    | Driver disponibili:
    | "single", "daily", "slack", "syslog",
    | "errorlog", "monolog", "custom", "stack"
    |
    */
    'channels' => [

        'stack' => [
            'driver' => 'stack',
            // Combina più canali in uno solo.

            'channels' => explode(',', (string) env('LOG_STACK', 'single')),
            // Elenco dei canali inclusi nello stack.

            'ignore_exceptions' => false,
            // Se true, ignora eccezioni generate dai canali interni.
        ],

        'single' => [
            'driver' => 'single',
            // Scrive tutti i log in un unico file.

            'path' => storage_path('logs/laravel.log'),
            // Percorso del file di log.

            'level' => env('LOG_LEVEL', 'debug'),
            // Livello minimo di log registrato.

            'replace_placeholders' => true,
            // Sostituisce placeholder PSR-3 nei messaggi.
        ],

        'daily' => [
            'driver' => 'daily',
            // Crea un file di log per ogni giorno.

            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),

            'days' => env('LOG_DAILY_DAYS', 14),
            // Numero di giorni per cui conservare i log.

            'replace_placeholders' => true,
        ],

        'slack' => [
            'driver' => 'slack',
            // Invia i log a un canale Slack tramite webhook.

            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => env('LOG_SLACK_USERNAME', 'Laravel Log'),
            'emoji' => env('LOG_SLACK_EMOJI', ':boom:'),

            'level' => env('LOG_LEVEL', 'critical'),
            // Invia solo log critici.

            'replace_placeholders' => true,
        ],

        'papertrail' => [
            'driver' => 'monolog',
            // Usa Monolog con handler personalizzato.

            'level' => env('LOG_LEVEL', 'debug'),

            'handler' => env('LOG_PAPERTRAIL_HANDLER', SyslogUdpHandler::class),
            // Handler per inviare log a Papertrail.

            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
                'connectionString' => 'tls://' . env('PAPERTRAIL_URL') . ':' . env('PAPERTRAIL_PORT'),
            ],

            'processors' => [PsrLogMessageProcessor::class],
            // Processor per formattazione PSR-3.
        ],

        'stderr' => [
            'driver' => 'monolog',
            // Scrive i log nello stream STDERR.

            'level' => env('LOG_LEVEL', 'debug'),

            'handler' => StreamHandler::class,
            'handler_with' => [
                'stream' => 'php://stderr',
            ],

            'formatter' => env('LOG_STDERR_FORMATTER'),
            // Formatter personalizzato (opzionale).

            'processors' => [PsrLogMessageProcessor::class],
        ],

        'syslog' => [
            'driver' => 'syslog',
            // Invia i log al sistema Syslog.

            'level' => env('LOG_LEVEL', 'debug'),

            'facility' => env('LOG_SYSLOG_FACILITY', LOG_USER),
            // Facility Syslog utilizzata.

            'replace_placeholders' => true,
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            // Scrive i log nell’error log del server.

            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

        'null' => [
            'driver' => 'monolog',
            // Canale che scarta tutti i log.

            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
            // Canale di fallback usato in caso di errori critici.
        ],

    ],

];
