<?php
// Apertura del file PHP.

/**
 * Notifica inviata a un utente quando la sua richiesta
 * per diventare revisore viene accettata da un amministratore.
 *
 * La notifica:
 * - viene salvata nel database
 * - viene inviata via email
 *
 * È utilizzata per informare l’utente del cambio di ruolo
 * e guidarlo verso il pannello dedicato ai revisori.
 */

namespace App\Notifications;
// Namespace delle notifiche Laravel.

use Illuminate\Bus\Queueable;
// Trait che permette di mettere la notifica in coda.

use Illuminate\Notifications\Messages\MailMessage;
// Classe che rappresenta un messaggio email formattato da Laravel.

use Illuminate\Notifications\Notification;
// Classe base per tutte le notifiche Laravel.


class ReviewerAcceptedNotification extends Notification
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
            'message' => 'La tua richiesta per diventare revisore è stata accettata!'
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
            ->subject('Richiesta revisore accettata')
            // Oggetto dell’email.

            ->line('Complimenti! La tua richiesta per diventare revisore è stata approvata.')
            // Messaggio principale.

            ->action('Accedi al pannello revisore', url('/revisor'))
            // Pulsante che porta al pannello revisore.

            ->line('Grazie per contribuire alla qualità della piattaforma.');
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
