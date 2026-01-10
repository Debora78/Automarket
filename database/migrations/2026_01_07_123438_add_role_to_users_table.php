<?php

/**
 * Migrazione che aggiunge alla tabella "users" il campo "role".
 *
 * Questo campo definisce il ruolo dell’utente all’interno dell’applicazione.
 * I ruoli previsti sono:
 * - user: utente normale
 * - reviewer: revisore degli annunci
 * - admin: amministratore
 *
 * Il valore predefinito è "user".
 */

use Illuminate\Database\Migrations\Migration;
// Classe base per definire una migrazione.

use Illuminate\Database\Schema\Blueprint;
// Classe che rappresenta la struttura di una tabella.

use Illuminate\Support\Facades\Schema;
// Facade per eseguire operazioni sul database.

return new class extends Migration
{
    /**
     * Esegue la migrazione aggiungendo la colonna "role" alla tabella users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')
                ->default('user')
                ->after('email');
            // Ruolo dell’utente (user, reviewer, admin).
        });
    }

    /**
     * Annulla la migrazione rimuovendo la colonna "role".
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            // Rimuove il campo role.
        });
    }
};
