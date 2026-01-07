/* Marquee effect (titolo scorrevole) */
document.addEventListener("DOMContentLoaded", () => {
    const marquee = document.getElementById("marquee-title");
    if (!marquee) return;

    const clone = marquee.cloneNode(true);
    marquee.parentNode.appendChild(clone);
});
