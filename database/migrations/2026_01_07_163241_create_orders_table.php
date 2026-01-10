<?php

/**
 * Migrazione che crea la tabella "orders".
 *
 * Questa tabella rappresenta gli ordini effettuati dagli utenti o dagli
 * utenti anonimi (tramite sessione). Ogni ordine contiene:
 *
 * - order_number: numero ordine univoco generato dall’app
 * - user_id: riferimento all’utente autenticato (se presente)
 * - session_id: riferimento alla sessione per ordini anonimi
 * - total: totale dell’ordine al momento dell’acquisto
 * - timestamps: created_at e updated_at
 *
 * La tabella è progettata per supportare sia checkout autenticati
 * che checkout guest.
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
     * Esegue la migrazione creando la tabella orders.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Chiave primaria auto-incrementale.

            $table->string('order_number')->unique();
            // Numero ordine univoco.

            $table->unsignedBigInteger('user_id')->nullable();
            // Utente che ha effettuato l’ordine (se autenticato).

            $table->string('session_id')->nullable();
            // Sessione associata all’ordine (per utenti anonimi).

            $table->decimal('total', 10, 2);
            // Totale dell’ordine.

            $table->timestamps();
            // created_at e updated_at.
        });
    }

    /**
     * Annulla la migrazione eliminando la tabella orders.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        // Elimina la tabella se esiste.
    }
};
