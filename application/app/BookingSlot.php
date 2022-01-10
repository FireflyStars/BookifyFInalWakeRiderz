<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingSlot extends Model
{
    protected $guarded = [];

    public function day()
    {
        return $this->belongsTo(BookingTime::class);
    }
}
