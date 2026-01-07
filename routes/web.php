<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminReviewerController;
use App\Http\Controllers\ReviewerRequestController;

Route::get('/', function () {
    return view('welcome');
})->name('homepage');

Route::get('/cars', [CarController::class, 'index'])->name('cars.index');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/reviewer-requests', [AdminReviewerController::class, 'index'])->name('admin.reviewer.index');
    Route::post('/admin/reviewer-requests/{id}/accept', [AdminReviewerController::class, 'accept'])->name('admin.reviewer.accept');
    Route::post('/admin/reviewer-requests/{id}/reject', [AdminReviewerController::class, 'reject'])->name('admin.reviewer.reject');
});


Route::post('/request-reviewer', [ReviewerRequestController::class, 'store'])
    ->middleware(['auth'])
    ->name('reviewer.request');


Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{car}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
});

require __DIR__ . '/auth.php';
