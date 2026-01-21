<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('hotels.index');
    })->name('dashboard');

    Route::get('hotels', [HotelController::class, 'index'])->middleware(['auth', 'verified'])->name('hotels.index');

    Route::controller(ReservationController::class)->group(function() {
        Route::get('reservations', 'index')->name('reservations.index');
        Route::get('reservations/{reservation}/cancel', 'cancel')->name('reservations.cancel');
        Route::post('reservations', 'store')->name('reservations.store');
        Route::get('hotels/{hotel}/reserve', 'create')->name('reservations.create');
    });

});

require __DIR__.'/settings.php';
