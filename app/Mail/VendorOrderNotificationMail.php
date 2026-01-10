<?php
// Apertura del file PHP.

/**
 * Questa classe rappresenta la mail inviata al venditore quando un suo veicolo
 * viene acquistato da un utente.
 *
 * Si occupa di:
 * - Ricevere l’ordine e l’auto venduta tramite dependency injection
 * - Rendere disponibili questi dati alla vista Blade dell’email
 * - Impostare l’oggetto della mail
 *
 * La classe contiene sia il metodo build() (approccio classico)
 * sia envelope()/content() (nuovo approccio Laravel 10+).
 * In produzione è consigliato usarne solo uno per coerenza.
 */

namespace App\Mail;
// Namespace dedicato alle classi Mailable.

use App\Models\Car;
// Modello Car, necessario per ottenere i dati del veicolo venduto.

use App\Models\Order;
// Modello Order, necessario per ottenere i dati dell’ordine.

use Illuminate\Bus\Queueable;
// Trait che permette di mettere la mail in coda.

use Illuminate\Mail\Mailable;
// Classe base per tutte le email in Laravel.

use Illuminate\Mail\Mailables\Content;
// Classe per definire il contenuto della mail (nuovo sistema Laravel 10+).

use Illuminate\Queue\SerializesModels;
// Trait che serializza automaticamente i modelli passati alla mail.

use Illuminate\Mail\Mailables\Envelope;
// Classe per definire l’envelope della mail (nuovo sistema Laravel 10+).

use Illuminate\Contracts\Queue\ShouldQueue;
// Interfaccia per mettere la mail in coda (non utilizzata qui).

class VendorOrderNotificationMail extends Mailable
// Mailable che notifica il venditore della vendita di un suo veicolo.
{
    use Queueable, SerializesModels;
    // Abilita code e serializzazione dei dati.

    public $order;
    // Istanza dell’ordine effettuato.

    public $car;
    // Istanza dell’auto venduta.

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, Car $car)
    // Costruttore che riceve i dati necessari alla mail.
    {
        $this->order = $order;
        // Assegna l’ordine.

        $this->car = $car;
        // Assegna l’auto venduta.
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    // Metodo del nuovo sistema Laravel 10+ per definire l’envelope.
    {
        return new Envelope(
            subject: 'Vendor Order Notification Mail',
            // Oggetto alternativo (non usato se build() è presente).
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    // Metodo del nuovo sistema Laravel 10+ per definire la vista.
    {
        return new Content(
            view: 'view.name',
            // Vista placeholder: non viene usata se build() è presente.
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    // Nessun allegato per questa mail.
    {
        return [];
    }
}
