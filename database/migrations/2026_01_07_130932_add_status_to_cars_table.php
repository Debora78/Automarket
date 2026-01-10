<?php

/**
 * Migrazione che aggiunge alla tabella "cars" il campo "status".
 *
 * Questo campo indica lo stato dell’annuncio auto e permette di gestire
 * il flusso di approvazione. I valori previsti sono:
 * - pending: annuncio in attesa di revisione
 * - approved: annuncio approvato
 * - rejected: annuncio rifiutato
 *
 * Il valore predefinito è "pending".
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
     * Esegue la migrazione aggiungendo la colonna "status" alla tabella cars.
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->string('status')
                ->default('pending')
                ->after('price');
            // Stato dell’annuncio (pending, approved, rejected).
        });
    }

    /**
     * Annulla la migrazione rimuovendo la colonna "status".
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('status');
            // Rimuove il campo status.
        });
    }
};
