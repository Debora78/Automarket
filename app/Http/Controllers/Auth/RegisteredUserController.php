<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce l’intero flusso di registrazione di un nuovo utente
 * tramite Laravel Fortify.
 *
 * Si occupa di:
 * - Mostrare la pagina di registrazione
 * - Validare i dati inviati dal form (nome, email, password)
 * - Creare un nuovo utente nel database in modo sicuro tramite hashing
 * - Dispatchare l’evento Registered per eventuali listener (es. invio email)
 * - Autenticare automaticamente l’utente appena registrato
 *
 * È un componente fondamentale del sistema di autenticazione e garantisce
 * un processo di registrazione sicuro, coerente e conforme alle policy
 * dell’applicazione.
 */

namespace App\Http\Controllers\Auth;
// Namespace che organizza i controller relativi all'autenticazione.

use App\Http\Controllers\Controller;
// Importa il controller base di Laravel da cui questo controller eredita.

use App\Models\User;
// Importa il modello User, necessario per creare un nuovo utente.

use Illuminate\Auth\Events\Registered;
// Importa l’evento Registered, dispatchato dopo la creazione dell’utente.

use Illuminate\Http\RedirectResponse;
// Importa la classe per risposte HTTP di tipo redirect.

use Illuminate\Http\Request;
// Importa la classe Request per accedere ai dati della richiesta HTTP.

use Illuminate\Support\Facades\Auth;
// Importa la facade Auth per autenticare l’utente.

use Illuminate\Support\Facades\Hash;
// Importa la facade Hash per criptare la password.

use Illuminate\Validation\Rules;
// Importa le regole di validazione, incluse quelle per la password.

use Illuminate\View\View;
// Importa la classe View per tipizzare il metodo che restituisce una vista.

class RegisteredUserController extends Controller
// Definisce il controller che gestisce la registrazione di nuovi utenti.
{
    /**
     * Display the registration view.
     */
    public function create(): View
    // Mostra la pagina di registrazione.
    {
        return view('auth.register');
        // Restituisce la vista 'auth.register'.
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    // Gestisce la richiesta di registrazione inviata dal form.
    {
        $request->validate([
            // Valida i dati inviati dal form.

            'name' => ['required', 'string', 'max:255'],
            // Il nome è obbligatorio, deve essere una stringa e lungo massimo 255 caratteri.

            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            // L’email è obbligatoria, deve essere valida, in minuscolo,
            // e unica nella tabella users.

            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // La password è obbligatoria, deve rispettare le regole di sicurezza
            // e deve essere confermata tramite password_confirmation.
        ]);

        $user = User::create([
            // Crea un nuovo utente nel database.

            'name' => $request->name,
            // Assegna il nome.

            'email' => $request->email,
            // Assegna l’email.

            'password' => Hash::make($request->password),
            // Cripta la password prima di salvarla.
        ]);

        event(new Registered($user));
        // Dispatcha l’evento Registered, utile per listener come l’invio dell’email di verifica.

        Auth::login($user);
        // Autentica automaticamente l’utente appena registrato.

        return redirect(route('dashboard', absolute: false));
        // Reindirizza l’utente alla dashboard.
    }
}
