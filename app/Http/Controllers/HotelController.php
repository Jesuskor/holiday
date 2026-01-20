<?php

namespace App\Http\Controllers;

use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $hotels = Hotel::query()
            ->select('id', 'name', 'city', 'star_rating', 'price_per_night', 'image_url')
            ->when($request->city, function ($query, $city) use ($request) {
                $query->where('city', $city);
            })
            ->when($request->stars, function ($query, $stars) use ($request) {
                $query->where('star_rating', $stars);
            })
            ->latest()->paginate(4)->withQueryString();

        $cities = Hotel::select('city')->distinct()->orderBy('city')->pluck('city');
        return Inertia::render('hotels/Index', [
            'hotels' => HotelResource::collection($hotels),
            'cities' => $cities,
            'filters' => $request->only(['city', 'stars']),
        ]);
    }
}
