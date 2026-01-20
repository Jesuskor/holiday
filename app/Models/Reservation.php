<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['hotel_id', 'guest_name', 'guest_email', 'check_in_date', 'check_out_date', 'guest_count', 'total_price', 'status'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

}
