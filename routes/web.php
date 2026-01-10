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

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
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
    ->name('reviewer.request');


/*
|--------------------------------------------------------------------------
| Carrello (solo autenticati)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add/{car}', [CartController::class, 'add'])
        ->name('cart.add');

    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])
        ->name('cart.remove');
});


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
