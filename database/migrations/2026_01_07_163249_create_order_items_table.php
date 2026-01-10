<?php

/**
 * Migrazione che crea la tabella "order_items".
 *
 * Questa tabella rappresenta le singole righe di un ordine.
 * Ogni elemento collega:
 * - un ordine (order_id)
 * - un’auto acquistata (car_id)
 * - il prezzo dell’auto al momento dell’acquisto
 *
 * La struttura permette di gestire ordini con più auto e di
 * mantenere uno storico accurato dei prezzi.
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
     * Esegue la migrazione creando la tabella order_items.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // Chiave primaria auto-incrementale.

            $table->unsignedBigInteger('order_id');
            // Ordine a cui appartiene l’elemento.

            $table->unsignedBigInteger('car_id');
            // Auto acquistata.

            $table->decimal('price', 10, 2);
            // Prezzo dell’auto al momento dell’acquisto.

            $table->timestamps();
            // created_at e updated_at.
        });
    }

    /**
     * Annulla la migrazione eliminando la tabella order_items.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        // Elimina la tabella se esiste.
    }
};
