<?php

/**
 * Migrazione che aggiunge tre nuovi campi alla tabella "cars":
 *
 * - brand: marca dell’auto (es. BMW, Audi, Fiat)
 * - year: anno di immatricolazione
 * - km: chilometraggio
 *
 * Tutti i campi sono nullable per permettere la creazione di annunci
 * anche senza informazioni complete.
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
     * Esegue la migrazione aggiungendo i nuovi campi alla tabella cars.
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->string('brand')->nullable();
            // Marca dell’auto.

            $table->integer('year')->nullable();
            // Anno di immatricolazione.

            $table->integer('km')->nullable();
            // Chilometraggio dell’auto.
        });
    }

    /**
     * Annulla la migrazione.
     *
     * Nota: attualmente non rimuove le colonne.
     * Se desideri una migrazione completamente reversibile,
     * posso aggiungere il dropColumn.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // $table->dropColumn(['brand', 'year', 'km']);
            // Campi non rimossi per scelta.
        });
    }
};
