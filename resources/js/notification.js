/**
 * --------------------------------------------------------------------------
 * Riproduzione suono per nuove notifiche
 * --------------------------------------------------------------------------
 * Questo script rileva l’arrivo di una nuova notifica confrontando
 * l’ID dell’ultima notifica ricevuta con quello salvato nel localStorage.
 *
 * Se l’ID è diverso, significa che è arrivata una notifica nuova:
 * → viene riprodotto un suono leggero
 * → viene aggiornato il valore salvato nel localStorage
 *
 * In questo modo il suono viene emesso solo quando serve davvero,
 * evitando ripetizioni inutili ad ogni refresh della pagina.
 *
 * Requisiti:
 * - window.Laravel.notifications deve contenere le notifiche dell’utente
 * - Il file audio deve esistere in /public/sounds/notification.mp3
 * - Il localStorage viene usato per ricordare l’ultima notifica letta
 *
 * Approccio leggero, non invasivo e perfetto per UX moderne.
 * --------------------------------------------------------------------------
 */

document.addEventListener("DOMContentLoaded", () => {
    // Se Laravel non ha caricato le notifiche, interrompi lo script.
    if (!window.Laravel || !Laravel.notifications) return;

    const lastNotificationId = localStorage.getItem("lastNotificationId");
    // Recupera l’ID dell’ultima notifica salvata.

    const notifications = Laravel.notifications;
    // Lista delle notifiche attuali dell’utente.

    if (notifications.length > 0) {
        const latest = notifications[0].id;
        // ID della notifica più recente.

        // Se è diversa da quella salvata, significa che è nuova.
        if (latest !== lastNotificationId) {
            const audio = new Audio("/sounds/notification.mp3");
            audio.volume = 0.4; // Volume leggero e non invasivo.
            audio.play();

            // Aggiorna l’ID salvato per evitare ripetizioni.
            localStorage.setItem("lastNotificationId", latest);
        }
    }
});
