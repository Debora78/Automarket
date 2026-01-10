<?php
// Apertura del file PHP.

/**
 * Service provider principale dell'applicazione.
 *
 * Si occupa di:
 * - Registrare servizi personalizzati (metodo register)
 * - Eseguire configurazioni globali all’avvio dell’app (metodo boot)
 *
 * In questo caso, abilita l’uso dello stile Tailwind
 * per i componenti di paginazione generati da Laravel.
 */

namespace App\Providers;
// Namespace dei service provider dell’applicazione.

use Illuminate\Pagination\Paginator;
// Classe responsabile della gestione della paginazione in Laravel.

use Illuminate\Support\ServiceProvider;
// Classe base per tutti i service provider di Laravel.


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * Metodo utilizzato per registrare servizi, binding o singleton
     * all’interno del service container di Laravel.
     * Attualmente non viene utilizzato.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * Metodo eseguito all’avvio dell’applicazione.
     * Qui viene configurato il sistema di paginazione
     * affinché utilizzi i componenti Tailwind CSS.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        // Imposta Tailwind come stile predefinito per la paginazione.
    }
}
