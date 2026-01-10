<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce tutte le operazioni relative al profilo utente,
 * inclusa la visualizzazione, l’aggiornamento delle informazioni personali
 * e l’eliminazione definitiva dell’account.
 *
 * Si occupa di:
 * - Mostrare il form di modifica del profilo
 * - Validare e aggiornare i dati dell’utente tramite ProfileUpdateRequest
 * - Reimpostare la verifica email se l’indirizzo viene modificato
 * - Eliminare l’account in modo sicuro dopo conferma della password
 *
 * È un componente fondamentale dell’area personale dell’utente e garantisce
 * un flusso sicuro e coerente per la gestione del proprio account.
 */

namespace App\Http\Controllers;
// Namespace che organizza i controller generici dell’applicazione.

use App\Http\Requests\ProfileUpdateRequest;
// Importa la Form Request che valida i dati del profilo.

use Illuminate\Http\RedirectResponse;
// Importa la classe per risposte HTTP di tipo redirect.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

use Illuminate\Support\Facades\Auth;
// Importa la facade Auth per gestire logout e autenticazione.

use Illuminate\Support\Facades\Redirect;
// Importa la facade Redirect per generare redirect puliti.

use Illuminate\View\View;
// Importa la classe View per tipizzare il metodo che restituisce una vista.

class ProfileController extends Controller
// Controller che gestisce la visualizzazione e modifica del profilo utente.
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    // Mostra il form di modifica del profilo.
    {
        return view('profile.edit', [
            'user' => $request->user(),
            // Passa l’utente autenticato alla vista.
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    // Aggiorna i dati del profilo utente.
    {
        $request->user()->fill($request->validated());
        // Riempie il modello User con i dati validati dalla Form Request.

        if ($request->user()->isDirty('email')) {
            // Se l’email è stata modificata:

            $request->user()->email_verified_at = null;
            // Resetta la verifica email: l’utente dovrà riconfermare il nuovo indirizzo.
        }

        $request->user()->save();
        // Salva le modifiche nel database.

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
        // Reindirizza al form con un messaggio di conferma.
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    // Elimina definitivamente l’account dell’utente.
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
            // Richiede la password attuale per confermare l’operazione.
        ]);

        $user = $request->user();
        // Recupera l’utente autenticato.

        Auth::logout();
        // Effettua il logout prima di eliminare l’account.

        $user->delete();
        // Elimina l’utente dal database.

        $request->session()->invalidate();
        // Invalida la sessione corrente.

        $request->session()->regenerateToken();
        // Rigenera il token CSRF per sicurezza.

        return Redirect::to('/');
        // Reindirizza alla homepage.
    }
}
