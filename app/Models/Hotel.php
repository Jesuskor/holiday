<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = ['name', 'city', 'address', 'star_rating', 'price_per_night', 'image_url'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function calculatePrice(string $checkIn, string $checkOut): float
    {
        $start = Carbon::parse($checkIn);
        $end = Carbon::parse($checkOut);
        $nights = $start->diffInDays($end);

        return $nights * $this->price_per_night;
    }
}
