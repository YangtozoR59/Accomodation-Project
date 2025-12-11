<?php

use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Owner\AccommodationController as OwnerAccommodationController;
use App\Http\Controllers\Owner\ReservationController as OwnerReservationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Hébergements (Public)
Route::get('/hebergements', [AccommodationController::class, 'index'])->name('accommodations.index');
Route::get('/hebergements/{id}', [AccommodationController::class, 'show'])->name('accommodations.show');
Route::post('/hebergements/{id}/check-availability', [AccommodationController::class, 'checkAvailability'])->name('accommodations.check-availability');


/*
|--------------------------------------------------------------------------
| Routes Authentifiées (Utilisateurs)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // Dashboard utilisateur
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Réservations (Client)
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::post('/', [ReservationController::class, 'store'])->name('store');
        Route::get('/{reservation}', [ReservationController::class, 'show'])->name('show');
        Route::patch('/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('cancel');
        Route::patch('/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('confirm');
        Route::patch('/{reservation}/complete', [ReservationController::class, 'complete'])->name('complete');
    });

    // Avis
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::post('/', [ReviewController::class, 'store'])->name('store');
        Route::patch('/{review}', [ReviewController::class, 'update'])->name('update');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Routes Propriétaires (Owner)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'owner'])->prefix('owner')->name('owner.')->group(function () {
    
    // Hébergements
    Route::prefix('accommodations')->name('accommodations.')->group(function () {
        Route::get('/', [OwnerAccommodationController::class, 'index'])->name('index');
        Route::get('/create', [OwnerAccommodationController::class, 'create'])->name('create');
        Route::post('/', [OwnerAccommodationController::class, 'store'])->name('store');
        Route::get('/{accommodation}/edit', [OwnerAccommodationController::class, 'edit'])->name('edit');
        Route::patch('/{accommodation}', [OwnerAccommodationController::class, 'update'])->name('update');
        Route::delete('/{accommodation}', [OwnerAccommodationController::class, 'destroy'])->name('destroy');
        
        // Gestion des images
        Route::delete('/images/{image}', [OwnerAccommodationController::class, 'deleteImage'])->name('images.delete');
        Route::patch('/images/{image}/set-primary', [OwnerAccommodationController::class, 'setPrimaryImage'])->name('images.set-primary');
    });

    // Réservations
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [OwnerReservationController::class, 'index'])->name('index');
        Route::get('/{reservation}', [OwnerReservationController::class, 'show'])->name('show');
    });
});

/*
|--------------------------------------------------------------------------
| Routes Administrateur (Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard admin
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des hébergements
    Route::get('/accommodations', [AdminDashboardController::class, 'accommodations'])->name('accommodations');
    Route::patch('/accommodations/{accommodation}/verify', [AdminDashboardController::class, 'verifyAccommodation'])->name('accommodations.verify');
    Route::patch('/accommodations/{accommodation}/reject', [AdminDashboardController::class, 'rejectAccommodation'])->name('accommodations.reject');
    
    // Gestion des avis
    Route::get('/reviews', [AdminDashboardController::class, 'reviews'])->name('reviews');
    Route::patch('/reviews/{review}/verify', [AdminDashboardController::class, 'verifyReview'])->name('reviews.verify');
    
    // Gestion des utilisateurs
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::patch('/users/{user}/toggle-status', [AdminDashboardController::class, 'toggleUserStatus'])->name('users.toggle-status');
});


require __DIR__.'/auth.php';