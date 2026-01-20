<?php

namespace App\Http\Controllers;

use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return Inertia::render('hotels/Index', [
            'hotels' => HotelResource::collection($hotels),
        ]);
    }
}
