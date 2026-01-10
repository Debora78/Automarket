<?php

/**
 * Migrazione che crea la tabella "categories".
 *
 * Questa tabella contiene l’elenco delle categorie utilizzate
 * nell’applicazione (es. categorie auto, filtri, ecc.).
 * Ogni categoria ha:
 * - un ID univoco
 * - un nome
 * - timestamp di creazione e aggiornamento
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
     * Esegue la migrazione creando la tabella categories.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // Chiave primaria auto-incrementale.

            $table->string('name');
            // Nome della categoria.

            $table->timestamps();
            // created_at e updated_at.
        });
    }

    /**
     * Annulla la migrazione eliminando la tabella categories.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        // Elimina la tabella se esiste.
    }
};
