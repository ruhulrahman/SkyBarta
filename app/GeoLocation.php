<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeoLocation extends Model
{
    protected $fillable = [
        'user_id',
        'address_address',
        'address_latitude',
        'address_longitude',
    ];
}
