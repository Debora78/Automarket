<?php
// Apertura del file PHP.

/**
 * Modello Eloquent che rappresenta una richiesta inviata da un utente
 * per diventare revisore (reviewer) all'interno della piattaforma.
 *
 * Si occupa di:
 * - Salvare lo stato della richiesta (pending, approved, rejected)
 * - Collegare la richiesta all’utente che l’ha inviata
 *
 * È utilizzato dal sistema di moderazione per gestire le richieste
 * e permettere agli admin di approvarle o rifiutarle.
 */

namespace App\Models;
// Namespace dei modelli Eloquent.

use Illuminate\Database\Eloquent\Model;
// Classe base dei modelli Eloquent.

class ReviewerRequest extends Model
// Modello che rappresenta una richiesta per diventare revisore.
{
    protected $fillable = ['user_id', 'status'];
    // Campi assegnabili in massa:
    // - user_id: utente che ha inviato la richiesta
    // - status: stato della richiesta (pending, approved, rejected)

    public function user()
    // Relazione: una richiesta appartiene a un utente.
    {
        return $this->belongsTo(User::class);
    }
}
