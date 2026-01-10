<?php

/**
 * File di configurazione dei service provider dell'applicazione.
 *
 * Qui vengono elencati i provider che Laravel deve caricare
 * automaticamente all'avvio dell'applicazione.
 *
 * Ogni provider è responsabile di registrare servizi,
 * configurazioni o funzionalità specifiche.
 */

return [
    App\Providers\AppServiceProvider::class,
    // Provider principale dell'applicazione: registra servizi generali
    // e configura impostazioni globali come la paginazione.

    App\Providers\FortifyServiceProvider::class,
    // Provider dedicato alla configurazione di Laravel Fortify:
    // gestisce autenticazione, registrazione, profili, password e 2FA.
];
