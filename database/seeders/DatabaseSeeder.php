<?php

/**
 * Seeder principale dell’applicazione.
 *
 * Questo seeder viene eseguito quando si lancia:
 *   php artisan db:seed
 *
 * Il suo compito è orchestrare tutti gli altri seeder necessari
 * per inizializzare il database con dati di base.
 *
 * Operazioni eseguite:
 * - Creazione di un utente di test tramite factory
 * - Popolamento delle categorie auto (CategorySeeder)
 * - Creazione/aggiornamento dell’utente amministratore (AdminUserSeeder)
 */

namespace Database\Seeders;

use App\Models\User;
// Modello User.

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// Trait opzionale per evitare eventi durante il seeding.

use Illuminate\Database\Seeder;
// Classe base per i seeder.

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Esegue il seeding dell’intero database.
     */
    public function run(): void
    {
        // Crea un utente di test tramite factory.
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Popola la tabella categories.
        $this->call(CategorySeeder::class);

        // Crea o aggiorna l’utente amministratore.
        $this->call(AdminUserSeeder::class);
    }
}
