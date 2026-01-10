/**
 * Effetto marquee (titolo scorrevole).
 *
 * Questo script duplica il contenuto del titolo scorrevole per creare
 * un loop continuo. Il clone viene aggiunto subito dopo l’elemento
 * originale, permettendo un’animazione fluida tramite CSS.
 */

document.addEventListener("DOMContentLoaded", () => {
    const marquee = document.getElementById("marquee-title");
    // Se l’elemento non esiste, interrompe lo script.
    if (!marquee) return;

    const clone = marquee.cloneNode(true);
    // Crea una copia identica del titolo.

    marquee.parentNode.appendChild(clone);
    // Aggiunge il clone subito dopo l’originale per creare l’effetto continuo.
});
