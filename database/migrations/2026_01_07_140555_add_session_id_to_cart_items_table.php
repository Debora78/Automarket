<?php

/**
 * Migrazione che aggiunge alla tabella "cart_items" il campo "session_id".
 *
 * Questo campo permette di associare gli elementi del carrello
 * a una sessione specifica, utile per gestire carrelli anonimi
 * (utenti non autenticati) o multipli.
 *
 * Il campo è indicizzato per migliorare le performance nelle query
 * che filtrano per sessione.
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
     * Esegue la migrazione aggiungendo la colonna session_id.
     */
    public function up(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->string('session_id')
                ->nullable()
                ->index()
                ->after('id');
            // Identificatore della sessione a cui appartiene il carrello.
        });
    }

    /**
     * Annulla la migrazione rimuovendo la colonna session_id.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('session_id');
            // Rimuove il campo session_id.
        });
    }
};
