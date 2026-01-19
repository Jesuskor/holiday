<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = ['name', 'city', 'address', 'star_rating', 'price_per_night', 'image_url'];
}
