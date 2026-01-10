<?php
// Apertura del file PHP.

/**
 * Classe base astratta per tutti i controller dell’applicazione.
 *
 * Questa classe funge da punto centrale di estensione per tutti i controller
 * personalizzati. Laravel utilizza questo approccio per fornire un luogo
 * comune in cui definire metodi, middleware o logiche condivise tra più
 * controller.
 *
 * Attualmente non contiene implementazioni, ma è pronta per ospitare
 * funzionalità comuni a tutti i controller dell’applicazione.
 */

namespace App\Http\Controllers;
// Namespace che organizza i controller dell’applicazione.

abstract class Controller
// Classe astratta che rappresenta il controller base da cui ereditano tutti gli altri controller.
{
    //
    // Attualmente vuota, ma può contenere logiche condivise tra più controller.
}
