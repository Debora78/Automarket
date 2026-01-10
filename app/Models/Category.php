<?php
// Apertura del file PHP.

/**
 * Modello Eloquent che rappresenta una categoria di veicoli.
 *
 * Si occupa di:
 * - Definire i campi assegnabili in massa (fillable)
 * - Gestire la relazione con il modello Car
 *
 * Ogni categoria può contenere più annunci auto,
 * ed è utilizzata nei filtri e nei form di creazione/modifica degli annunci.
 */

namespace App\Models;
// Namespace dei modelli Eloquent.

use Illuminate\Database\Eloquent\Model;
// Classe base dei modelli Eloquent.

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Trait che abilita le factory per test e seed.

class Category extends Model
// Modello che rappresenta una categoria di veicoli.
{
    use HasFactory;
    // Abilita la factory per questo modello.

    protected $fillable = ['name'];
    // Campi assegnabili in massa:
    // - name: nome della categoria (es. SUV, Berlina, Utilitaria)

    public function cars()
    // Relazione: una categoria contiene molti veicoli.
    {
        return $this->hasMany(Car::class);
    }
}
