<?php
// Apertura del file PHP.

/**
 * Modello Eloquent che rappresenta un singolo articolo appartenente a un ordine.
 *
 * Si occupa di:
 * - Collegare un ordine a una specifica auto acquistata
 * - Salvare il prezzo dell’auto al momento dell’acquisto
 * - Definire le relazioni con Order e Car
 *
 * È utilizzato durante il checkout per registrare ogni veicolo acquistato
 * e per generare riepiloghi, fatture e notifiche.
 */

namespace App\Models;
// Namespace dei modelli Eloquent.

use Illuminate\Database\Eloquent\Model;
// Classe base dei modelli Eloquent.

class OrderItem extends Model
// Modello che rappresenta un singolo articolo di un ordine.
{
    protected $fillable = [
        'order_id',
        'car_id',
        'price',
    ];
    // Campi assegnabili in massa:
    // - order_id: ordine a cui appartiene l’articolo
    // - car_id: auto acquistata
    // - price: prezzo dell’auto al momento dell’acquisto

    public function order()
    // Relazione: ogni articolo appartiene a un ordine.
    {
        return $this->belongsTo(Order::class);
    }

    public function car()
    // Relazione: ogni articolo fa riferimento a una singola auto.
    {
        return $this->belongsTo(Car::class);
    }
}
