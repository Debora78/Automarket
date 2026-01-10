<?php

/**
 * Migrazione che crea la tabella "reviewer_requests".
 *
 * Questa tabella registra le richieste degli utenti che desiderano diventare
 * revisori. Ogni richiesta contiene:
 * - l’utente che l’ha inviata
 * - lo stato della richiesta (pending, accepted, rejected)
 * - i timestamp di creazione e aggiornamento
 *
 * Se l’utente viene eliminato, anche la sua richiesta viene rimossa.
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
     * Esegue la migrazione creando la tabella reviewer_requests.
     */
    public function up(): void
    {
        Schema::create('reviewer_requests', function (Blueprint $table) {
            $table->id();
            // Chiave primaria auto-incrementale.

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            // Utente che ha inviato la richiesta.
            // Se l’utente viene eliminato, la richiesta viene rimossa.

            $table->string('status')->default('pending');
            // Stato della richiesta: pending, accepted, rejected.

            $table->timestamps();
            // created_at e updated_at.
        });
    }

    /**
     * Annulla la migrazione eliminando la tabella reviewer_requests.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewer_requests');
        // Elimina la tabella se esiste.
    }
};
