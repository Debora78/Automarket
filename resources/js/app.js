// ---------------------------------------------------------
// 1) Bootstrap di Laravel (configurazioni di base)
// ---------------------------------------------------------
import "./bootstrap";

// ---------------------------------------------------------
// 2) Script generali del progetto (navbar, ecc.)
//    ⚠️ Devono essere caricati PRIMA di Alpine
// ---------------------------------------------------------
import "./index";

// ---------------------------------------------------------
// 3) Script per il titolo scorrevole (marquee)
//    ⚠️ Anche questo deve essere caricato prima di Alpine
// ---------------------------------------------------------
import "./marquee.js";

// ---------------------------------------------------------
// 4) Funzione Typewriter
//    ⚠️ Deve essere esposta su window PRIMA che Alpine parta
// ---------------------------------------------------------
import { typewriter } from "./typewriter.js";
window.typewriter = typewriter;

// ---------------------------------------------------------
// 5) Alpine.js
//    ⚠️ Deve essere avviato SOLO dopo aver definito window.typewriter
// ---------------------------------------------------------
import Alpine from "alpinejs";
window.Alpine = Alpine;

Alpine.start();
