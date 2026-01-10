<?php

/**
 * Migrazione che crea le tabelle fondamentali per:
 * - utenti (users)
 * - token di reset password (password_reset_tokens)
 * - sessioni (sessions)
 *
 * Queste tabelle sono necessarie per il sistema di autenticazione,
 * gestione sessioni e recupero password dell’applicazione.
 */

use Illuminate\Database\Migrations\Migration;
// Classe base per definire una migrazione.

use Illuminate\Database\Schema\Blueprint;
// Classe che rappresenta la struttura di una tabella.

use Illuminate\Support\Facades\Schema;
// Facade per gestire le operazioni sul database.

return new class extends Migration
{
    /**
     * Esegue la migrazione creando le tabelle necessarie.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // Chiave primaria auto-incrementale.

            $table->string('name');
            // Nome dell’utente.

            $table->string('email')->unique();
            // Email univoca.

            $table->timestamp('email_verified_at')->nullable();
            // Timestamp della verifica email.

            $table->string('password');
            // Password hashata.

            $table->rememberToken();
            // Token per la funzionalità "remember me".

            $table->timestamps();
            // created_at e updated_at.
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            // Email come chiave primaria.

            $table->string('token');
            // Token di reset password.

            $table->timestamp('created_at')->nullable();
            // Data di creazione del token.
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            // ID univoco della sessione.

            $table->foreignId('user_id')->nullable()->index();
            // ID utente associato alla sessione (se presente).

            $table->string('ip_address', 45)->nullable();
            // Indirizzo IP dell’utente (IPv4 o IPv6).

            $table->text('user_agent')->nullable();
            // User agent del browser.

            $table->longText('payload');
            // Dati della sessione serializzati.

            $table->integer('last_activity')->index();
            // Timestamp dell’ultima attività.
        });
    }

    /**
     * Annulla la migrazione eliminando le tabelle create.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        // Elimina la tabella utenti.

        Schema::dropIfExists('password_reset_tokens');
        // Elimina la tabella dei token di reset.

        Schema::dropIfExists('sessions');
        // Elimina la tabella delle sessioni.
    }
};
