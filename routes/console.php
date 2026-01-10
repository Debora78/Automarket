<?php

/**
 * ---------------------------------------------------------------
 *  Console Commands (Automarket)
 * ---------------------------------------------------------------
 *  Questo file definisce i comandi Artisan personalizzati.
 *
 *  Comando incluso:
 *  • inspire → mostra una citazione motivazionale casuale
 *
 *  Utilizzo:
 *      php artisan inspire
 *
 *  Nota:
 *  Questo file è parte della configurazione console di Laravel
 *  e può essere esteso aggiungendo nuovi comandi personalizzati.
 * ---------------------------------------------------------------
 */

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
