<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

// Public route for QR scan
Route::get('/scan/{tagCode}', [TagController::class, 'scan'])->name('tags.scan');

// Root: send authenticated users to dashboard, guests to login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated application routes
Route::middleware('auth')->group(function () {
    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customers
    Route::resource('customers', CustomerController::class);

    // Pets nested under customers
    Route::prefix('customers/{customer}')->group(function () {
        Route::get('pets', [PetController::class, 'index'])->name('customers.pets.index');
        Route::get('pets/create', [PetController::class, 'create'])->name('customers.pets.create');
        Route::post('pets', [PetController::class, 'store'])->name('customers.pets.store');
        Route::get('pets/{pet}', [PetController::class, 'show'])->name('customers.pets.show');
        Route::get('pets/{pet}/edit', [PetController::class, 'edit'])->name('customers.pets.edit');
        Route::put('pets/{pet}', [PetController::class, 'update'])->name('customers.pets.update');
        Route::delete('pets/{pet}', [PetController::class, 'destroy'])->name('customers.pets.destroy');
        Route::post('pets/{pet}/treatments', [PetController::class, 'addTreatment'])->name('customers.pets.treatments.store');
    });

    // Collaborators (admin only)
    Route::middleware('admin')->group(function () {
        Route::resource('collaborators', CollaboratorController::class);
    });

    // Bookings
    Route::resource('bookings', BookingController::class);
    Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    // Tags
    Route::resource('tags', TagController::class);
    Route::get('tags/{tag}/download', [TagController::class, 'download'])->name('tags.download');
});

// Breeze auth routes
require __DIR__.'/auth.php';
