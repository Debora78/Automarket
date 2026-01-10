<?php

/**
 * Migrazione che crea le tabelle necessarie per il sistema di cache
 * quando si utilizza il driver "database".
 *
 * Le tabelle create sono:
 * - cache: memorizza le chiavi, i valori serializzati e la loro scadenza
 * - cache_locks: gestisce i lock per operazioni concorrenti sulla cache
 *
 * Queste strutture permettono a Laravel di utilizzare il database come
 * backend per la cache e per i meccanismi di locking.
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
     * Esegue la migrazione creando le tabelle della cache.
     */
    public function up(): void
    {
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            // Chiave univoca della cache.

            $table->mediumText('value');
            // Valore serializzato della cache.

            $table->integer('expiration');
            // Timestamp di scadenza.
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            // Chiave del lock.

            $table->string('owner');
            // Identificatore del processo che possiede il lock.

            $table->integer('expiration');
            // Timestamp di scadenza del lock.
        });
    }

    /**
     * Annulla la migrazione eliminando le tabelle create.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        // Elimina la tabella della cache.

        Schema::dropIfExists('cache_locks');
        // Elimina la tabella dei lock.
    }
};
