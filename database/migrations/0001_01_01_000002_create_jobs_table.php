<?php

/**
 * Migrazione che crea le tabelle necessarie per il sistema di code (queue)
 * di Laravel:
 *
 * - jobs: contiene i job in attesa di essere processati
 * - job_batches: contiene informazioni sui batch di job
 * - failed_jobs: registra i job falliti
 *
 * Queste tabelle sono fondamentali per la gestione asincrona dei processi.
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
     * Esegue la migrazione creando le tabelle delle code.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            // ID univoco del job.

            $table->string('queue')->index();
            // Nome della coda a cui appartiene il job.

            $table->longText('payload');
            // Dati serializzati del job.

            $table->unsignedTinyInteger('attempts');
            // Numero di tentativi già effettuati.

            $table->unsignedInteger('reserved_at')->nullable();
            // Timestamp in cui il job è stato riservato da un worker.

            $table->unsignedInteger('available_at');
            // Timestamp in cui il job diventa disponibile.

            $table->unsignedInteger('created_at');
            // Timestamp di creazione del job.
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            // ID univoco del batch.

            $table->string('name');
            // Nome del batch.

            $table->integer('total_jobs');
            // Numero totale di job nel batch.

            $table->integer('pending_jobs');
            // Job ancora in attesa.

            $table->integer('failed_jobs');
            // Numero di job falliti.

            $table->longText('failed_job_ids');
            // Elenco degli ID dei job falliti.

            $table->mediumText('options')->nullable();
            // Opzioni aggiuntive serializzate.

            $table->integer('cancelled_at')->nullable();
            // Timestamp di annullamento del batch.

            $table->integer('created_at');
            // Timestamp di creazione del batch.

            $table->integer('finished_at')->nullable();
            // Timestamp di completamento del batch.
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            // ID univoco del job fallito.

            $table->string('uuid')->unique();
            // UUID del job.

            $table->text('connection');
            // Connessione utilizzata.

            $table->text('queue');
            // Nome della coda.

            $table->longText('payload');
            // Dati serializzati del job.

            $table->longText('exception');
            // Eccezione generata dal job.

            $table->timestamp('failed_at')->useCurrent();
            // Timestamp del fallimento.
        });
    }

    /**
     * Annulla la migrazione eliminando le tabelle create.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        // Elimina la tabella dei job.

        Schema::dropIfExists('job_batches');
        // Elimina la tabella dei batch.

        Schema::dropIfExists('failed_jobs');
        // Elimina la tabella dei job falliti.
    }
};
