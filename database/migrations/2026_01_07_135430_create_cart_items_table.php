<?php

/**
 * Migrazione che crea la tabella "cart_items".
 *
 * Questa tabella rappresenta gli elementi presenti nel carrello.
 * Al momento contiene solo l’ID e i timestamp, ma potrà essere
 * estesa in seguito con:
 * - riferimento all’utente
 * - riferimento all’auto
 * - quantità
 * - prezzo al momento dell’aggiunta
 *
 * La struttura è volutamente minimale per permettere evoluzioni future.
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
     * Esegue la migrazione creando la tabella cart_items.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            // Chiave primaria auto-incrementale.

            $table->timestamps();
            // created_at e updated_at.
        });
    }

    /**
     * Annulla la migrazione eliminando la tabella cart_items.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
        // Elimina la tabella se esiste.
    }
};
