<?php

/**
 * Seeder che crea o aggiorna l’utente amministratore dell’applicazione.
 *
 * Questo seeder utilizza updateOrCreate per garantire che:
 * - se l’utente con l’email specificata esiste, viene aggiornato
 * - se non esiste, viene creato
 *
 * L’utente generato avrà ruolo "admin" e una password predefinita
 * (da modificare in produzione).
 */

namespace Database\Seeders;

use App\Models\User;
// Modello User.

use Illuminate\Database\Seeder;
// Classe base per i seeder.

use Illuminate\Support\Facades\Hash;
// Facade per hashare la password.

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// Trait opzionale per evitare eventi durante il seeding.

class AdminUserSeeder extends Seeder
{
    /**
     * Esegue il seeding creando o aggiornando l’utente admin.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@automarket.it'],
            // Condizione di ricerca: email dell’admin.

            [
                'name' => 'Admin Automarket',
                // Nome visualizzato dell’admin.

                'password' => Hash::make('password123'),
                // Password hashata (da cambiare in produzione).

                'role' => 'admin',
                // Ruolo amministratore.
            ]
        );
    }
}
