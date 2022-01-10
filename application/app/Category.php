<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function addons()
    {
        return $this->hasMany(Addon::class);
    }

    public function provider()
    {
        return $this->hasMany(StaffMemberService::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(CouponCode::class, 'category_coupon')->withTimestamps();
    }
}
