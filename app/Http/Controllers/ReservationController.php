<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Hotel;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReservationController extends Controller
{
    public function index() {
        $reservations = Reservation::with('hotel')->latest()->paginate(4)->withQueryString();
        return Inertia::render('reservations/Index', [
            'reservations' => ReservationResource::collection($reservations)
        ]);
    }
    public function create(Hotel $hotel) {
        return Inertia::render('reservations/Create', ['hotel' => $hotel]);
    }

    public function store(StoreReservationRequest $request) {
        $hotel = Hotel::findOrFail($request->hotel_id);

        $totalPrice = $hotel->calculatePrice(
            $request->check_in_date,
            $request->check_out_date
        );

        Reservation::create([
            ...$request->validated(),
            'total_price' => $totalPrice
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservación creada con éxito');
    }
}
