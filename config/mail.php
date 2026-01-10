<?php

/**
 * File di configurazione del sistema di invio email di Laravel.
 *
 * Qui vengono definiti:
 * - il mailer predefinito utilizzato dall’applicazione
 * - tutti i mailer disponibili (SMTP, Sendmail, SES, Postmark, ecc.)
 * - l’indirizzo email globale "from" usato per tutte le email
 *
 * Laravel supporta diversi driver di trasporto email, ognuno configurabile
 * tramite variabili d’ambiente (.env). Questo file permette di gestire
 * facilmente più mailer e fallback in caso di errori.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | Mailer predefinito utilizzato per inviare email.
    | Se non specificato altrove, Laravel userà questo mailer.
    |
    */
    'default' => env('MAIL_MAILER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Elenco di tutti i mailer configurabili.
    | Ogni mailer utilizza un driver di trasporto diverso.
    |
    | Driver supportati:
    | "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    | "postmark", "resend", "log", "array",
    | "failover", "roundrobin"
    |
    */
    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            // Usa il protocollo SMTP per inviare email.

            'scheme' => env('MAIL_SCHEME'),
            // Schema di connessione (es. tls, ssl).

            'url' => env('MAIL_URL'),
            // URL completo SMTP (opzionale).

            'host' => env('MAIL_HOST', '127.0.0.1'),
            // Host del server SMTP.

            'port' => env('MAIL_PORT', 2525),
            // Porta SMTP.

            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            // Credenziali SMTP.

            'timeout' => null,
            // Timeout connessione.

            'local_domain' => env(
                'MAIL_EHLO_DOMAIN',
                parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)
            ),
            // Dominio usato nel comando EHLO.
        ],

        'ses' => [
            'transport' => 'ses',
            // Usa Amazon SES per inviare email.
        ],

        'postmark' => [
            'transport' => 'postmark',
            // Usa Postmark come provider email.
        ],

        'resend' => [
            'transport' => 'resend',
            // Usa Resend come provider email.
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            // Usa il comando sendmail del server.

            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
            // Percorso del binario sendmail.
        ],

        'log' => [
            'transport' => 'log',
            // Scrive le email nei log invece di inviarle.

            'channel' => env('MAIL_LOG_CHANNEL'),
            // Canale di log dedicato (opzionale).
        ],

        'array' => [
            'transport' => 'array',
            // Le email vengono salvate in un array (utile per test).
        ],

        'failover' => [
            'transport' => 'failover',
            // Prova più mailer in ordine finché uno non funziona.

            'mailers' => [
                'smtp',
                'log',
            ],
            // Primo tentativo: SMTP → fallback: log.

            'retry_after' => 60,
            // Tempo di attesa prima di ritentare.
        ],

        'roundrobin' => [
            'transport' => 'roundrobin',
            // Alterna tra più mailer in ordine circolare.

            'mailers' => [
                'ses',
                'postmark',
            ],

            'retry_after' => 60,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | Indirizzo email globale utilizzato come mittente per tutte le email.
    | Può essere sovrascritto nei singoli Mailable.
    |
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        // Indirizzo mittente predefinito.

        'name' => env('MAIL_FROM_NAME', 'Example'),
        // Nome visualizzato come mittente.
    ],

];
