<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingTime extends Model
{
    protected $guarded = [];

    public function slots()
    {
        return $this->hasMany(BookingSlot::class);
    }
}
