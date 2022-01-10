<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionAddon extends Model
{
    protected $guarded = [];

    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }

}
