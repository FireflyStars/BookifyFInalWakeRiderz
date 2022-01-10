<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffMemberService extends Model
{
    protected $guarded = [];

    public function staff()
    {
        return $this->belongsTo(StaffMember::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
