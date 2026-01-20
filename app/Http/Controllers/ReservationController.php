<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReservationController extends Controller
{
    public function index() {
        return Inertia::render('reservations/Index');
    }
    public function create(Hotel $hotel) {
        return Inertia::render('reservations/Create', ['hotel' => $hotel]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'hotel_id'      => 'required|exists:hotels,id',
            'guest_name'    => 'required|string|max:255',
            'guest_email'   => 'required|email',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date'=> 'required|date|after:check_in_date',
            'guest_count'   => 'required|integer|min:1',
        ]);

        $hotel = Hotel::findOrFail($validated['hotel_id']);
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);
        $totalToCharge = $nights * $hotel->price_per_night;

        $validated['total_price'] = $totalToCharge;
        Reservation::create($validated);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservación creada con éxito');
    }
}
