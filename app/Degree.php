<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $table = 'degrees';
    protected $fillable = [
        'name',
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;
}
