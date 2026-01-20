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
        $query = Hotel::query();

        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        $cities = Hotel::select('city')->distinct()->orderBy('city')->pluck('city');
        return Inertia::render('hotels/Index', [
            'hotels' => HotelResource::collection($query->paginate(4)->withQueryString()),
            'cities' => $cities,
            'filters' => $request->only('city'),
        ]);
    }
}
