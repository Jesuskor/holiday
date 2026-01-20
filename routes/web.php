<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('hotels', [HotelController::class, 'index'])->middleware(['auth', 'verified'])->name('hotels.index');
Route::get('hotels/{hotel}/reserve', [ReservationController::class, 'create'])->middleware(['auth', 'verified'])->name('reservations.create');
Route::post('reservations', [ReservationController::class, 'store'])->middleware(['auth', 'verified'])->name('reservations.store');
Route::get('reservations', [ReservationController::class, 'index'])->middleware(['auth', 'verified'])->name('reservations.index');
Route::patch('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->middleware(['auth', 'verified'])->name('reservations.cancel');

require __DIR__.'/settings.php';
