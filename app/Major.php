<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $table = 'majors';
    protected $fillable = [
        'name',
    ];

    
    protected $primaryKey = 'id';
    public $timestamps = false;
}
