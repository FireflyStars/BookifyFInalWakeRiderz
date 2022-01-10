<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function addons()
    {
        return $this->belongsToMany(Addon::class)->withTimestamps();
    }

    public function cancel_request()
    {
        return $this->hasOne(CancelRequest::class);
    }

    public function staff()
    {
        return $this->belongsTo(StaffMember::class, 'staff_member_id');
    }
}
