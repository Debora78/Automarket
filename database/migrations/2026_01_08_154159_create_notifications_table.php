<?php

/**
 * Migrazione che crea la tabella "notifications".
 *
 * Questa tabella viene utilizzata dal sistema di notifiche di Laravel
 * per memorizzare tutte le notifiche inviate agli utenti o ad altri
 * modelli notificabili.
 *
 * Ogni notifica contiene:
 * - id UUID univoco
 * - type: classe della notifica
 * - notifiable_id + notifiable_type: relazione polimorfica
 * - data: payload JSON della notifica
 * - read_at: timestamp di lettura
 * - timestamps: created_at e updated_at
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
     * Esegue la migrazione creando la tabella notifications.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // Identificatore univoco della notifica.

            $table->string('type');
            // Classe della notifica (es. App\Notifications\NewOrder).

            $table->morphs('notifiable');
            // Relazione polimorfica: notifiable_id + notifiable_type.

            $table->text('data');
            // Dati della notifica in formato JSON.

            $table->timestamp('read_at')->nullable();
            // Timestamp che indica quando la notifica è stata letta.

            $table->timestamps();
            // created_at e updated_at.
        });
    }

    /**
     * Annulla la migrazione eliminando la tabella notifications.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        // Elimina la tabella se esiste.
    }
};
