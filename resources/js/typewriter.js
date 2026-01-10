/**
 * Funzione Typewriter.
 *
 * Restituisce un oggetto reattivo utilizzabile in Alpine.js per creare
 * l’effetto “macchina da scrivere”. Il testo viene mostrato un carattere
 * alla volta con una velocità configurabile. Al termine, se fornita,
 * viene eseguita una callback.
 *
 * Parametri:
 * - text: testo completo da scrivere
 * - speed: velocità in millisecondi tra un carattere e l’altro (default 80ms)
 * - callback: funzione opzionale da eseguire al termine dell’animazione
 */

export function typewriter(text, speed = 80, callback = null) {
    return {
        full: text, // Testo completo da scrivere.
        displayed: "", // Testo attualmente mostrato.
        index: 0, // Posizione corrente nel testo.

        start() {
            // Avvia l’animazione carattere per carattere.
            const interval = setInterval(() => {
                if (this.index < this.full.length) {
                    this.displayed += this.full[this.index];
                    this.index++;
                } else {
                    // Fine animazione: interrompe l’intervallo.
                    clearInterval(interval);

                    // Esegue la callback se presente.
                    if (callback) callback();
                }
            }, speed);
        },
    };
}
