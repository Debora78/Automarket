<?php

/**
 * Migrazione che aggiunge al modello User i campi necessari
 * per la gestione della Two-Factor Authentication (2FA) tramite Fortify.
 *
 * I campi aggiunti sono:
 * - two_factor_secret: chiave segreta TOTP
 * - two_factor_recovery_codes: codici di recupero criptati
 * - two_factor_confirmed_at: timestamp di conferma della 2FA
 *
 * Questi campi vengono aggiunti dopo la colonna "password" per coerenza logica.
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
     * Esegue la migrazione aggiungendo le colonne 2FA alla tabella users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_secret')
                ->after('password')
                ->nullable();
            // Chiave segreta TOTP per la 2FA.

            $table->text('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();
            // Codici di recupero criptati per la 2FA.

            $table->timestamp('two_factor_confirmed_at')
                ->after('two_factor_recovery_codes')
                ->nullable();
            // Timestamp che indica quando la 2FA è stata confermata.
        });
    }

    /**
     * Annulla la migrazione rimuovendo le colonne aggiunte.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_confirmed_at',
            ]);
            // Rimuove tutti i campi relativi alla 2FA.
        });
    }
};
