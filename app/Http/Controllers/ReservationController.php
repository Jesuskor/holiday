<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReservationController extends Controller
{
    public function create(Hotel $hotel) {
        return Inertia::render('reservations/Create', ['hotel' => $hotel]);
    }
}
