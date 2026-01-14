<?php

/**
 * Tabella pivot "favorites"
 * - Collega utenti e auto
 * - Ogni riga rappresenta un’auto salvata nei preferiti da un utente
 * - OnDelete cascade: se l’utente o l’auto vengono eliminati,
 *   i preferiti collegati vengono rimossi automaticamente
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esegue la creazione della tabella "favorites".
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();

            // Utente che salva l’auto
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Auto salvata nei preferiti
            $table->foreignId('car_id')
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Elimina la tabella "favorites".
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
