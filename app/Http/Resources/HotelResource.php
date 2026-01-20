<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'address' => $this->when($request->routeIs('hotels.show'), $this->address),
            'star_rating' => $this->star_rating,
            'price_per_night' => $this->price_per_night,
            'image_url' => $this->image_url,
        ];
    }
}
