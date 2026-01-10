<?php

/**
 * File di bootstrap dell'applicazione Laravel.
 *
 * Questo file configura:
 * - il percorso base dell'applicazione
 * - le rotte (web, console, health check)
 * - il middleware globale
 * - la gestione delle eccezioni
 *
 * Fa parte della nuova struttura introdotta nelle versioni moderne di Laravel,
 * dove la configurazione dell'applicazione avviene tramite metodi fluenti.
 */

use Illuminate\Foundation\Application;
// Classe principale che rappresenta l'applicazione Laravel.

use Illuminate\Foundation\Configuration\Exceptions;
// Classe che permette di configurare la gestione delle eccezioni.

use Illuminate\Foundation\Configuration\Middleware;
// Classe che permette di configurare il middleware globale.

return Application::configure(basePath: dirname(__DIR__))
    // Configura l'applicazione indicando la directory base.

    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        // File delle rotte web.

        commands: __DIR__ . '/../routes/console.php',
        // File dei comandi Artisan personalizzati.

        health: '/up',
        // Endpoint di health check usato da sistemi esterni.
    )

    ->withMiddleware(function (Middleware $middleware): void {
        // Qui è possibile registrare middleware globali o gruppi personalizzati.
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        // Qui è possibile configurare la gestione delle eccezioni personalizzate.
    })

    ->create();
// Crea e restituisce l'istanza finale dell'applicazione.