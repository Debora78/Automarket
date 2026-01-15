<?php

/**
 * --------------------------------------------------------------------------
 *  Comando Artisan: user:make-admin
 * --------------------------------------------------------------------------
 *  Questo comando permette di rendere amministratore un utente esistente
 *  tramite la sua email. Viene utilizzato per assegnare rapidamente il ruolo
 *  admin senza dover modificare manualmente il database.
 *
 *  Utilizzo:
 *      php artisan user:make-admin email@example.com
 *
 *  Funzionamento:
 *  - Riceve l'email come argomento
 *  - Cerca l'utente nel database
 *  - Se non esiste, mostra un errore
 *  - Se esiste, imposta is_admin = 1 e salva
 *  - Mostra un messaggio di conferma
 * --------------------------------------------------------------------------
 */

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    /**
     * Firma del comando Artisan.
     * Definisce il nome del comando e l'argomento richiesto (email).
     */
    protected $signature = 'user:make-admin {email}';

    /**
     * Descrizione del comando, visibile con:
     * php artisan list
     */
    protected $description = 'Rende amministratore un utente tramite email';

    /**
     * Metodo principale eseguito quando il comando viene lanciato.
     */
    public function handle()
    {
        // Recupera l'email passata come argomento
        $email = $this->argument('email');

        // Cerca l'utente nel database tramite email
        $user = User::where('email', $email)->first();

        // Se l'utente non esiste, mostra un errore e interrompe l'esecuzione
        if (! $user) {
            $this->error("Utente con email {$email} non trovato.");
            return;
        }

        // Imposta il ruolo admin
        $user->role = 1;

        // Salva la modifica nel database
        $user->save();

        // Messaggio di conferma
        $this->info("L'utente {$email} è ora amministratore.");
    }
}
