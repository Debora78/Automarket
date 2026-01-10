<?php

/**
 * Seeder che popola la tabella "categories" con un elenco di categorie auto.
 *
 * Questo seeder crea automaticamente le categorie principali utilizzate
 * nell’applicazione per classificare gli annunci. Ogni categoria viene
 * creata solo con il campo "name".
 */

namespace Database\Seeders;

use App\Models\Category;
// Modello Category.

use Illuminate\Database\Seeder;
// Classe base per i seeder.

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// Trait opzionale per evitare eventi durante il seeding.

class CategorySeeder extends Seeder
{
    /**
     * Esegue il seeding creando le categorie predefinite.
     */
    public function run(): void
    {
        $categories = [
            'City Car',
            'Utilitaria',
            'Berlina',
            'SUV',
            'Coupé',
            'Cabrio',
            'Station Wagon',
            'Sportiva',
            'Elettrica',
            'Ibrida',
        ];
        // Elenco delle categorie auto da inserire.

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
            // Crea una categoria con il nome specificato.
        }
    }
}
