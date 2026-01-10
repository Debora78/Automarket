<?php
// Apertura del file PHP.

/**
 * Questo middleware controlla che l’utente autenticato abbia il ruolo
 * di revisore (reviewer) prima di accedere alle rotte riservate.
 *
 * Si occupa di:
 * - Verificare che l’utente sia autenticato
 * - Controllare che il metodo isReviewer() del model User restituisca true
 * - Bloccare l’accesso con errore 403 se l’utente non è autorizzato
 *
 * È un componente fondamentale per proteggere le sezioni dedicate ai revisori
 * e garantire che solo utenti approvati possano accedervi.
 */

namespace App\Http\Middleware;
// Namespace che organizza i middleware dell’applicazione.

use Closure;
// Importa la classe Closure, necessaria per la pipeline dei middleware.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

use Illuminate\Support\Facades\Auth;
// Importa la facade Auth per verificare autenticazione e ruolo dell’utente.

use Symfony\Component\HttpFoundation\Response;
// Importa la classe Response per tipizzare il valore di ritorno.

class ReviewerMiddleware
// Middleware che permette l’accesso solo agli utenti con ruolo di revisore.
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    // Metodo principale del middleware: controlla i permessi e prosegue la richiesta.
    {
        if (!Auth::check() || !Auth::user()->isReviewer()) {
            // Se l’utente non è autenticato O non è un revisore:

            abort(403, 'Accesso negato');
            // Interrompe la richiesta restituendo un errore 403.
        }

        return $next($request);
        // Se l’utente è un revisore, la richiesta prosegue normalmente.
    }
}
