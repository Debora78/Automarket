<?php
// Apertura del file PHP.

/**
 * Modello Eloquent che rappresenta un singolo elemento del carrello.
 *
 * Si occupa di:
 * - Collegare un veicolo (car_id) a un carrello utente o guest (user_id o session_id)
 * - Gestire la quantità dell’articolo nel carrello
 * - Definire la relazione con il modello Car
 *
 * È utilizzato dal sistema di carrello per gestire gli articoli aggiunti
 * sia dagli utenti autenticati che dagli utenti guest tramite sessione.
 */

namespace App\Models;
// Namespace dei modelli Eloquent.

use Illuminate\Database\Eloquent\Model;
// Classe base dei modelli Eloquent.

class CartItem extends Model
// Modello che rappresenta un singolo elemento del carrello.
{
    protected $fillable = ['session_id', 'user_id', 'car_id', 'quantity'];
    // Campi assegnabili in massa:
    // - session_id: identifica il carrello di un utente guest
    // - user_id: identifica il carrello di un utente autenticato
    // - car_id: veicolo aggiunto al carrello
    // - quantity: quantità dell’articolo (di solito 1 per le auto)

    public function car()
    // Relazione: un elemento del carrello appartiene a un veicolo.
    {
        return $this->belongsTo(Car::class);
    }
}
