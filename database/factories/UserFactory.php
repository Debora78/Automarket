<?php

/**
 * Factory dedicata alla generazione di istanze fittizie del modello User.
 *
 * Utilizzata principalmente nei seeder e nei test per creare utenti
 * realistici con dati casuali (nome, email, password, token, ecc.).
 *
 * La factory sfrutta Faker per generare dati casuali e mantiene una
 * password statica per evitare di rigenerarla inutilmente.
 */

namespace Database\Factories;
// Namespace dedicato alle factory dei modelli.

use Illuminate\Database\Eloquent\Factories\Factory;
// Classe base per definire una factory Eloquent.

use Illuminate\Support\Facades\Hash;
// Facade per gestire l'hashing delle password.

use Illuminate\Support\Str;
// Helper per generare stringhe casuali.

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 * Estende la factory base specificando che questa factory genera utenti.
 */
class UserFactory extends Factory
{
    /**
     * Password statica condivisa tra tutte le istanze generate.
     * Evita di rigenerare l'hash ad ogni creazione.
     */
    protected static ?string $password;

    /**
     * Definisce lo stato predefinito del modello User.
     *
     * @return array<string, mixed>  Array di attributi da assegnare all'utente.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            // Nome completo generato casualmente.

            'email' => fake()->unique()->safeEmail(),
            // Email univoca e sicura generata da Faker.

            'email_verified_at' => now(),
            // Timestamp che indica che l'email è verificata.

            'password' => static::$password ??= Hash::make('password'),
            // Password hashata. Viene generata una sola volta.

            'remember_token' => Str::random(10),
            // Token casuale per la funzionalità "remember me".
        ];
    }

    /**
     * Imposta lo stato dell'utente come "non verificato".
     *
     * Utile nei test per simulare utenti che non hanno ancora
     * confermato la loro email.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
            // Rimuove la verifica dell'email.
        ]);
    }
}
