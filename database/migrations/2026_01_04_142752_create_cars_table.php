<?php

/**
 * Migrazione che crea la tabella "cars".
 *
 * Questa tabella contiene tutte le informazioni relative agli annunci auto
 * pubblicati dagli utenti, incluse:
 * - titolo
 * - descrizione
 * - prezzo
 * - categoria associata
 * - utente proprietario dell’annuncio
 * - stato di approvazione
 *
 * Sono inoltre definiti i vincoli di relazione con:
 * - categories (categoria dell’auto)
 * - users (utente che ha creato l’annuncio)
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
     * Esegue la migrazione creando la tabella cars.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            // Chiave primaria auto-incrementale.

            $table->string('title');
            // Titolo dell’annuncio.

            $table->text('description');
            // Descrizione dettagliata dell’auto.

            $table->decimal('price', 10, 2);
            // Prezzo dell’auto con due decimali.

            $table->unsignedBigInteger('category_id');
            // ID della categoria associata.

            $table->unsignedBigInteger('user_id');
            // ID dell’utente che ha creato l’annuncio.

            $table->boolean('is_approved')->default(false);
            // Indica se l’annuncio è stato approvato da un admin.

            $table->timestamps();
            // created_at e updated_at.

            // Relazione con categories: se la categoria viene eliminata,
            // vengono eliminati anche gli annunci associati.
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            // Relazione con users: se l’utente viene eliminato,
            // vengono eliminati anche i suoi annunci.
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Annulla la migrazione eliminando la tabella cars.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
        // Elimina la tabella se esiste.
    }
};
