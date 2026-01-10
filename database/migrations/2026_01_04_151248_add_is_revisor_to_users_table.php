<?php

/**
 * Migrazione che aggiunge alla tabella "users" il campo "is_revisor".
 *
 * Questo campo indica se un utente ha il ruolo di revisore,
 * ovvero se può approvare o rifiutare gli annunci pubblicati.
 *
 * Il valore predefinito è false, quindi gli utenti non sono revisori
 * a meno che non vengano promossi manualmente.
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
     * Esegue la migrazione aggiungendo il campo is_revisor.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_revisor')->default(false);
            // Indica se l’utente è un revisore.
        });
    }

    /**
     * Annulla la migrazione.
     *
     * Nota: qui non viene rimosso il campo.
     * Se desideri una migrazione completamente reversibile,
     * puoi aggiungere il dropColumn.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->dropColumn('is_revisor');
            // Campo non rimosso per scelta.
        });
    }
};
