/**
 * Configurazione Axios globale.
 *
 * Questo file:
 * - importa Axios
 * - lo espone su window per l’uso in tutto il progetto
 * - imposta l’header X-Requested-With per identificare le richieste AJAX
 */

import axios from "axios";
// Importa la libreria Axios.

window.axios = axios;
// Rende Axios disponibile globalmente (es. in script inline o Alpine).

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
// Indica al server che la richiesta è AJAX (utile per Laravel).
