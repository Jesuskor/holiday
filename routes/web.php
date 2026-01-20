<?php

use App\Http\Controllers\HotelController;
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

require __DIR__.'/settings.php';
