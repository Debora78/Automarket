<?php
// Apertura del file PHP.

/**
 * Questa classe rappresenta l’email di conferma ordine inviata all’utente
 * dopo il completamento di un acquisto.
 *
 * Si occupa di:
 * - Ricevere gli articoli acquistati, il totale e il nome della fattura
 * - Rendere disponibili questi dati alla vista Blade dell’email
 * - Impostare l’oggetto della mail
 *
 * È una Mailable semplice ma fondamentale per la comunicazione post-acquisto.
 */

namespace App\Mail;
// Namespace dedicato alle classi Mailable.

use Illuminate\Bus\Queueable;
// Trait che permette di mettere la mail in coda.

use Illuminate\Mail\Mailable;
// Classe base per tutte le email in Laravel.

use Illuminate\Queue\SerializesModels;
// Trait che serializza automaticamente i modelli passati alla mail.

class OrderConfirmationMail extends Mailable
// Mailable che gestisce l’invio della conferma ordine.
{
    use Queueable, SerializesModels;
    // Abilita code e serializzazione dei dati.

    public $items;
    // Lista degli articoli acquistati.

    public $total;
    // Totale dell’ordine.

    public $invoiceName;
    // Nome del file PDF della fattura (se generato).

    /**
     * Crea una nuova istanza della mail.
     */
    public function __construct($items, $total, $invoiceName)
    // Costruttore che riceve i dati necessari alla mail.
    {
        $this->items = $items;
        // Assegna gli articoli acquistati.

        $this->total = $total;
        // Assegna il totale dell’ordine.

        $this->invoiceName = $invoiceName;
        // Assegna il nome della fattura.
    }

    /**
     * Costruisce la mail.
     */
    public function build()
    // Definisce oggetto e vista della mail.
    {
        return $this->subject('Conferma ordine - Automarket')
            // Imposta l’oggetto dell’email.

            ->view('emails.order-confirmation');
        // Specifica la vista Blade da utilizzare.
    }
}
