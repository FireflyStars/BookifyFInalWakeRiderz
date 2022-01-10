<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $guarded = [];

    protected $public_images = "/images/";

    public function getFileAttribute($photo)
    {
        return $this->public_images.$photo;
    }
}