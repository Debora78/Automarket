<?php

/**
 * File di configurazione per i servizi di terze parti.
 *
 * Questo file contiene le credenziali e le impostazioni necessarie
 * per integrare servizi esterni come:
 * - Postmark
 * - Resend
 * - Amazon SES
 * - Slack
 *
 * Centralizzare queste configurazioni permette ai pacchetti
 * e all’applicazione di trovare facilmente i dati necessari
 * per comunicare con provider esterni.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Postmark
    |--------------------------------------------------------------------------
    |
    | Configurazione per il servizio email Postmark.
    | Richiede una API key definita nel file .env.
    |
    */
    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Resend
    |--------------------------------------------------------------------------
    |
    | Configurazione per il servizio email Resend.
    | Anche qui la chiave API è definita nel file .env.
    |
    */
    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Amazon SES
    |--------------------------------------------------------------------------
    |
    | Configurazione per Amazon Simple Email Service (SES).
    | Richiede credenziali AWS e la regione di utilizzo.
    |
    */
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Slack
    |--------------------------------------------------------------------------
    |
    | Configurazione per l’invio di notifiche Slack tramite bot.
    | Richiede un token OAuth e un canale predefinito.
    |
    */
    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
