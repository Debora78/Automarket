<?php

/**
 * --------------------------------------------------------------------------
 *  WEB ROUTES — Automarket
 * --------------------------------------------------------------------------
 *  Questo file contiene tutte le rotte principali dell’applicazione web.
 *
 *  STRUTTURA GENERALE:
 *  • Homepage
 *  • Annunci pubblici (listing + dettaglio)
 *  • Creazione annunci (solo utenti autenticati)
 *  • Dashboard utente (auth + email verificata)
 *  • Profilo utente (modifica, update, delete)
 *  • Area Admin (gestione richieste revisore)
 *  • Area Revisore (moderazione annunci)
 *  • Richiesta ruolo revisore
 *  • Carrello (solo autenticati)
 *  • Ordini (solo autenticati)
 *  • Checkout (Stripe)
 *  • Notifiche utente
 *
 *  NOTA:
 *  Le rotte di autenticazione standard (login, register, reset password, ecc.)
 *  sono definite nel file `auth.php` incluso in fondo.
 * --------------------------------------------------------------------------
 */

use App\Livewire\CreateCar;

// Controller principali
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSecurityController;

// Controller per revisori e amministratori
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewerCarController;
use App\Http\Controllers\AdminReviewerController;
use App\Http\Controllers\ReviewerRequestController;


// Debug
Route::get('/debug-test', function () {
    return 'QUESTO È IL WEB.PHP GIUSTO';
});


/*
|--------------------------------------------------------------------------
| Homepage
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('homepage');


/*
|--------------------------------------------------------------------------
| Annunci (pubblici)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Pagina "I miei annunci"
    Route::get('/my-cars', [CarController::class, 'myCars'])
        ->name('user.cars');
});

// Lista auto
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');

Route::middleware(['auth'])->group(function () {

    // Form creazione auto
    Route::get('/cars/create', CreateCar::class)->name('cars.create');

    // Salvataggio nuova auto
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
});

// Dettaglio auto
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
/*
|--------------------------------------------------------------------------
| Modifica ed eliminazione annunci (solo autenticati)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Modifica annuncio
    Route::get('/cars/{car}/edit', [CarController::class, 'edit'])
        ->name('cars.edit');

    // Aggiornamento annuncio
    Route::put('/cars/{car}', [CarController::class, 'update'])
        ->name('cars.update');

    // Eliminazione annuncio
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])
        ->name('cars.destroy');
});



/*
|--------------------------------------------------------------------------
| Dashboard utente (solo autenticati e verificati)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Profilo utente
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Preferiti (solo utenti autenticati)
|--------------------------------------------------------------------------
| - L’utente può salvare auto nei preferiti
| - Può visualizzare la lista completa
| - Può aggiungere o rimuovere auto
| - Tutto è legato all’utente tramite tabella pivot "favorites"
*/
Route::middleware('auth')->group(function () {

    // Pagina preferiti
    Route::get('/favorites', [CarController::class, 'favorites'])
        ->name('favorites.index');

    // Aggiungi ai preferiti
    Route::post('/favorites/{car}', [CarController::class, 'addToFavorites'])
        ->name('favorites.add');

    // Rimuovi dai preferiti
    Route::delete('/favorites/{car}', [CarController::class, 'removeFromFavorites'])
        ->name('favorites.remove');
});


Route::middleware(['auth'])->group(function () {

    // Pagina sicurezza e password
    Route::get('/security', [ProfileSecurityController::class, 'index'])
        ->name('password.change');

    // Cambio password
    Route::post('/security/password', [ProfileSecurityController::class, 'updatePassword'])
        ->name('password.update');

    // Attiva 2FA
    Route::post('/security/2fa/enable', [ProfileSecurityController::class, 'enable2FA'])
        ->name('2fa.enable');

    // Disattiva 2FA
    Route::post('/security/2fa/disable', [ProfileSecurityController::class, 'disable2FA'])
        ->name('2fa.disable');

    // Rigenera codici di recupero
    Route::post('/security/2fa/recovery-codes', [ProfileSecurityController::class, 'regenerateRecoveryCodes'])
        ->name('2fa.recovery');
});
/*
|--------------------------------------------------------------------------
| Area Admin (gestione richieste revisore)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/reviewer-requests', [AdminReviewerController::class, 'index'])
        ->name('admin.reviewer.index');

    Route::post('/admin/reviewer-requests/{id}/accept', [AdminReviewerController::class, 'accept'])
        ->name('admin.reviewer.accept');

    Route::post('/admin/reviewer-requests/{id}/reject', [AdminReviewerController::class, 'reject'])
        ->name('admin.reviewer.reject');
});


/*
|--------------------------------------------------------------------------
| Area Revisore (moderazione annunci)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'reviewer'])->group(function () {

    Route::get('/reviewer/cars', [ReviewerCarController::class, 'index'])
        ->name('reviewer.cars.index');

    Route::post('/reviewer/cars/{car}/approve', [ReviewerCarController::class, 'approve'])
        ->name('reviewer.cars.approve');

    Route::post('/reviewer/cars/{car}/reject', [ReviewerCarController::class, 'reject'])
        ->name('reviewer.cars.reject');
});


/*
|--------------------------------------------------------------------------
| Richiesta ruolo revisore (utente → admin)
|--------------------------------------------------------------------------
*/
Route::post('/request-reviewer', [ReviewerRequestController::class, 'store'])
    ->middleware(['auth'])
    ->name('become.revisor');


/*
|--------------------------------------------------------------------------
| Carrello accessibile a tutti (guest + utenti)
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{car}', [CartController::class, 'add'])
    ->name('cart.add');

Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])
    ->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Ordini (solo autenticati)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');
});


/*
|--------------------------------------------------------------------------
| Checkout (Stripe)
|--------------------------------------------------------------------------
*/
Route::post('/checkout', [CheckoutController::class, 'checkout'])
    ->name('checkout');

Route::get('/checkout/success', [CheckoutController::class, 'success'])
    ->name('checkout.success');


/*
|--------------------------------------------------------------------------
| Notifiche utente
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/notifications', function () {
        return view('notifications.index');
    })->name('notifications.index');

    Route::post('/notifications/mark-all-read', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllRead');

    Route::post('/notifications/{id}/read', function ($id) {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back();
    })->name('notifications.read');

    Route::delete('/notifications/{id}', function ($id) {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        return back();
    })->name('notifications.delete');

    Route::delete('/notifications', function () {
        Auth::user()->notifications()->delete();
        return back();
    })->name('notifications.deleteAll');
});


/*
|--------------------------------------------------------------------------
| Rotte di autenticazione standard (login, register, ecc.)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
