<?php

/**
 * Migrazione che crea la tabella "images".
 *
 * Questa tabella contiene i percorsi delle immagini associate alle auto.
 * Ogni immagine appartiene a un singolo annuncio (car) e viene eliminata
 * automaticamente se l’annuncio associato viene cancellato.
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
     * Esegue la migrazione creando la tabella images.
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            // Chiave primaria auto-incrementale.

            $table->string('path');
            // Percorso del file immagine salvato nello storage.

            $table->unsignedBigInteger('car_id');
            // ID dell’auto a cui l’immagine appartiene.

            $table->timestamps();
            // created_at e updated_at.

            // Relazione con cars: se l’auto viene eliminata,
            // vengono eliminate anche le immagini associate.
            $table->foreign('car_id')
                ->references('id')
                ->on('cars')
                ->onDelete('cascade');
        });
    }

    /**
     * Annulla la migrazione eliminando la tabella images.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
        // Elimina la tabella se esiste.
    }
};
