<?php
// Apertura del file PHP.

/**
 * Modello Eloquent che rappresenta un veicolo pubblicato dagli utenti.
 *
 * Si occupa di:
 * - Definire i campi assegnabili in massa (fillable)
 * - Gestire il cast dell’attributo accessories come array JSON
 * - Definire le relazioni con Category, User e Image
 * - Fornire scope per filtrare auto approvate o in attesa
 *
 * Questo modello è centrale per tutto il sistema di annunci.
 */


namespace App\Models;
// Namespace dei modelli Eloquent.

use Illuminate\Database\Eloquent\Model;
// Classe base dei modelli Eloquent.

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Trait per abilitare le factory nei test e seed.

class Car extends Model
// Modello che rappresenta un annuncio auto.
{
    use HasFactory;
    // Abilita la factory per questo modello.

    protected $fillable = [
        'title',
        'description',
        'price',
        'status',
        'category_id',
        'user_id',
        'brand',
        'year',
        'km',
        'listing_type',
        'color',
        'accessories',
    ];
    // Campi assegnabili in massa tramite create() o update().

    /* salvare/leggere accessories come array, non come stringa */
    protected $casts = [
        'accessories' => 'array',
        // Converte automaticamente JSON <-> array PHP.
    ];

    public function category()
    // Relazione: un’auto appartiene a una categoria.
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    // Relazione: un’auto appartiene a un utente (venditore).
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    // Relazione: un’auto ha molte immagini.
    {
        return $this->hasMany(Image::class);
    }
    // Auto approvate
    public function scopeApproved($query)
    // Scope per filtrare auto approvate.
    {
        return $query->where('status', 'approved');
    }
    // Auto in attesa
    public function scopePending($query)
    // Scope per filtrare auto in attesa di approvazione.
    {
        return $query->where('status', 'pending');
        // Stessa nota: verifica che la colonna sia "status".
    }
}
