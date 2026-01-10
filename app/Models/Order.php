<?php
// Apertura del file PHP.

/**
 * Modello Eloquent che rappresenta un ordine effettuato da un utente
 * o da un visitatore guest tramite sessione.
 *
 * Si occupa di:
 * - Definire i campi assegnabili in massa (fillable)
 * - Gestire la relazione con gli articoli dell’ordine (OrderItem)
 * - Collegare l’ordine a un utente autenticato (se presente)
 *
 * È utilizzato durante il checkout per salvare i dati dell’acquisto
 * e per generare email di conferma e notifiche ai venditori.
 */

namespace App\Models;
// Namespace dei modelli Eloquent.

use Illuminate\Database\Eloquent\Model;
// Classe base dei modelli Eloquent.

class Order extends Model
// Modello che rappresenta un ordine effettuato sul sito.
{
    protected $fillable = [
        'order_number',
        'user_id',
        'session_id',
        'total',
    ];
    // Campi assegnabili in massa:
    // - order_number: codice univoco dell’ordine
    // - user_id: utente autenticato che ha effettuato l’acquisto (se presente)
    // - session_id: identificatore del carrello guest
    // - total: totale dell’ordine

    public function items()
    // Relazione: un ordine contiene molti articoli (OrderItem).
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    // Relazione: un ordine appartiene a un utente (solo se loggato).
    {
        return $this->belongsTo(User::class);
    }
}
