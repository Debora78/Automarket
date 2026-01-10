<?php

/**
 * Migrazione che aggiunge alla tabella "orders" il campo "invoice_name".
 *
 * Questo campo permette di memorizzare il nome intestatario della fattura
 * associata all’ordine. È opzionale (nullable) per consentire ordini
 * effettuati senza dati di fatturazione completi.
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
     * Esegue la migrazione aggiungendo la colonna invoice_name.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('invoice_name')
                ->nullable()
                ->after('total');
            // Nome intestatario della fattura.
        });
    }

    /**
     * Annulla la migrazione.
     *
     * Nota: attualmente non rimuove la colonna.
     * Se vuoi una migrazione completamente reversibile,
     * posso aggiungere il dropColumn.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // $table->dropColumn('invoice_name');
            // Campo non rimosso per scelta.
        });
    }
};
