<?php

namespace App\Models;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [];

    Public function province(){
        return $this->belongsTo(Province::class);
    }

    Public function city(){
        return $this->belongsTo(City::class);
    }
}
