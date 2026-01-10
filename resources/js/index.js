/**
 * Effetto scroll per la navbar.
 *
 * Quando l’utente scrolla oltre 10px, viene aggiunta la classe
 * "navbar-scrolled", che aumenta il glow verde. Quando torna in alto,
 * la classe viene rimossa.
 */

document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.getElementById("navbar");
    // Selettore della navbar.

    window.addEventListener("scroll", () => {
        // Controlla la distanza di scroll verticale.
        if (window.scrollY > 10) {
            navbar.classList.add("navbar-scrolled");
            // Aggiunge il glow più intenso.
        } else {
            navbar.classList.remove("navbar-scrolled");
            // Ripristina il glow normale.
        }
    });
});
