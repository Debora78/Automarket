<?php
// Apertura del file PHP.

/**
 * Modello Eloquent che rappresenta un utente registrato nella piattaforma.
 *
 * Si occupa di:
 * - Gestire autenticazione, notifiche e serializzazione sicura dei dati
 * - Definire i campi assegnabili e nascosti
 * - Applicare cast automatici (password hashed, email_verified_at datetime)
 * - Gestire le relazioni con Car e ReviewerRequest
 * - Fornire metodi helper per verificare il ruolo dell’utente
 *
 * È il modello centrale per la gestione degli utenti, dei ruoli e
 * delle funzionalità di moderazione.
 */

namespace App\Models;
// Namespace dei modelli Eloquent.

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Trait per generare factory per test e seed.

use Illuminate\Foundation\Auth\User as Authenticatable;
// Classe base per utenti autenticabili.

use Illuminate\Notifications\Notifiable;
// Trait per inviare notifiche (email, database, ecc.).

class User extends Authenticatable
// Modello che rappresenta un utente registrato.
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    // Abilita factory e notifiche.

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    // Campi assegnabili in massa.

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    // Campi nascosti quando l’utente viene serializzato (API, JSON, ecc.).

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    // Cast automatici applicati agli attributi.
    {
        return [
            'email_verified_at' => 'datetime',
            // Converte automaticamente in Carbon.

            'password' => 'hashed',
            // Applica hashing automatico alla password.
        ];
    }

    public function cars()
    // Relazione: un utente può pubblicare molte auto.
    {
        return $this->hasMany(Car::class);
    }

    public function isAdmin(): bool
    // Ritorna true se l’utente ha ruolo admin.
    {
        return $this->role === 'admin';
    }

    public function isRevisor(): bool
    // Ritorna true se l’utente è un revisore.
    {
        return $this->is_revisor;
        // ⚠️ Nota: richiede una colonna "is_revisor" nella tabella users.
    }

    public function isUser(): bool
    // Ritorna true se l’utente è un utente normale.
    {
        return $this->role === 'user';
    }

    public function reviewerRequest()
    // Relazione: un utente può avere una sola richiesta per diventare revisore.
    {
        return $this->hasOne(ReviewerRequest::class);
    }

    /**
     * Relazione molti-a-molti tra User e Car.
     * Un utente può salvare più auto nei preferiti.
     * La tabella pivot è "favorites".
     */
    public function favorites()
    {
        return $this->belongsToMany(Car::class, 'favorites')->withTimestamps();
    }
}
