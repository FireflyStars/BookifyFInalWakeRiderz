<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffMember extends Model
{
    protected $guarded = [];

    public function services()
    {
        return $this->hasMany(StaffMemberService::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
