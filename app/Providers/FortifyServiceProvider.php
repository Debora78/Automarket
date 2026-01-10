<?php
// Apertura del file PHP.

/**
 * Service provider dedicato alla configurazione di Laravel Fortify.
 *
 * Si occupa di:
 * - Registrare le azioni personalizzate per la gestione utenti
 * - Configurare il rate limiting per login e 2FA
 * - Definire le viste personalizzate per login e registrazione
 *
 * Questo file è fondamentale per controllare il comportamento
 * dell’autenticazione e della sicurezza dell’applicazione.
 */

namespace App\Providers;
// Namespace dei service provider dell’applicazione.

use App\Actions\Fortify\CreateNewUser;
// Classe che gestisce la creazione di un nuovo utente.

use App\Actions\Fortify\ResetUserPassword;
// Classe che gestisce il reset della password.

use App\Actions\Fortify\UpdateUserPassword;
// Classe che gestisce l’aggiornamento della password dell’utente.

use App\Actions\Fortify\UpdateUserProfileInformation;
// Classe che gestisce l’aggiornamento dei dati del profilo utente.

use Illuminate\Cache\RateLimiting\Limit;
// Classe che definisce i limiti di rate limiting.

use Illuminate\Http\Request;
// Classe che rappresenta una richiesta HTTP.

use Illuminate\Support\Facades\RateLimiter;
// Facade per configurare il rate limiting.

use Illuminate\Support\ServiceProvider;
// Classe base per tutti i service provider di Laravel.

use Illuminate\Support\Str;
// Classe helper per la manipolazione di stringhe.

use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
// Azione che gestisce il redirect per utenti con 2FA attivo.

use Laravel\Fortify\Fortify;
// Classe principale per configurare Laravel Fortify.


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * Metodo utilizzato per registrare servizi o binding
     * all’interno del service container.
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
     * Qui vengono configurate tutte le funzionalità di Fortify.
     */
    public function boot(): void
    {
        // Azione per creare un nuovo utente.
        Fortify::createUsersUsing(CreateNewUser::class);

        // Azione per aggiornare le informazioni del profilo.
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);

        // Azione per aggiornare la password dell’utente.
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);

        // Azione per resettare la password.
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Redirect automatico se l’utente ha 2FA attivo.
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        // Rate limiting per il login: massimo 5 tentativi al minuto.
        RateLimiter::for('login', function (Request $request) {
            // Genera una chiave unica basata su username + IP.
            $throttleKey = Str::transliterate(
                Str::lower($request->input(Fortify::username())) . '|' . $request->ip()
            );

            return Limit::perMinute(5)->by($throttleKey);
        });

        // Rate limiting per la verifica 2FA: massimo 5 tentativi al minuto.
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // Vista personalizzata per il login.
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // Vista personalizzata per la registrazione.
        Fortify::registerView(function () {
            return view('auth.register');
        });
    }
}
