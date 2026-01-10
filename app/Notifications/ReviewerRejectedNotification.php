<?php
// Apertura del file PHP.

/**
 * Notifica inviata quando la richiesta di diventare revisore
 * viene rifiutata da un amministratore.
 *
 * La notifica viene:
 * - salvata nel database
 * - inviata via email
 *
 * Serve per informare l’utente dell’esito negativo della richiesta.
 */

namespace App\Notifications;
// Namespace delle notifiche Laravel.

use Illuminate\Bus\Queueable;
// Trait che permette di mettere la notifica in coda.

use Illuminate\Notifications\Messages\MailMessage;
// Classe che rappresenta un messaggio email formattato da Laravel.

use Illuminate\Notifications\Notification;
// Classe base per tutte le notifiche Laravel.


class ReviewerRejectedNotification extends Notification
{
    use Queueable;
    // Abilita la gestione asincrona tramite code (opzionale).

    /**
     * Canali di consegna della notifica.
     *
     * In questo caso:
     * - 'mail' → invia un'email all'utente
     * - 'database' → salva la notifica nella tabella notifications
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Dati salvati nel database.
     *
     * Questi dati saranno visibili nel pannello notifiche dell’utente.
     */
    public function toDatabase($notifiable): array
    {
        return [
            'message' => 'La tua richiesta per diventare revisore è stata rifiutata.'
        ];
    }

    /**
     * Rappresentazione email della notifica.
     *
     * Viene inviata all’indirizzo email dell’utente.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Richiesta revisore rifiutata')
            // Oggetto dell’email.

            ->line('La tua richiesta per diventare revisore non è stata approvata.')
            // Messaggio principale.

            ->line('Puoi riprovare in futuro o contattare il supporto per maggiori informazioni.')
            // Messaggio aggiuntivo.

            ->action('Torna al sito', url('/'))
            // Pulsante che riporta alla homepage.

            ->line('Grazie per aver utilizzato la nostra piattaforma.');
        // Messaggio finale.
    }

    /**
     * Rappresentazione array della notifica (fallback).
     *
     * Usata solo da sistemi esterni o API se necessario.
     */
    public function toArray($notifiable): array
    {
        return [];
    }
}
