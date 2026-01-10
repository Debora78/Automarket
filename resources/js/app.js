// ---------------------------------------------------------
// 1) Bootstrap di Laravel (configurazioni di base)
// ---------------------------------------------------------
// Inizializza Axios, CSRF token e altre configurazioni essenziali
// fornite da Laravel. Deve essere sempre il primo import.
import "./bootstrap";

// ---------------------------------------------------------
// 2) Script generali del progetto (navbar, effetti, ecc.)
//    ⚠️ Devono essere caricati PRIMA di Alpine
// ---------------------------------------------------------
// Contiene logica globale come gestione navbar, scroll, glow, ecc.
import "./index";

// ---------------------------------------------------------
// 3) Script per il titolo scorrevole (marquee)
//    ⚠️ Anche questo deve essere caricato prima di Alpine
// ---------------------------------------------------------
// Gestisce l’effetto di testo scorrevole nella navbar o altrove.
import "./marquee.js";

// ---------------------------------------------------------
// 4) Script notifiche (suono nuove notifiche)
//    ⚠️ Non dipende da Alpine, può stare qui
// ---------------------------------------------------------
// Riproduce un suono quando arrivano nuove notifiche.
import "./notification.js";

// ---------------------------------------------------------
// 5) Funzione Typewriter
//    ⚠️ Deve essere esposta su window PRIMA che Alpine parta
// ---------------------------------------------------------
// Import della funzione e assegnazione a window per renderla
// disponibile nei componenti Alpine.
import { typewriter } from "./typewriter.js";
window.typewriter = typewriter;

// ---------------------------------------------------------
// 6) Alpine.js
//    ⚠️ Deve essere avviato SOLO dopo aver definito window.typewriter
// ---------------------------------------------------------
// Inizializzazione del framework Alpine.js.
import Alpine from "alpinejs";
window.Alpine = Alpine;

Alpine.start();
