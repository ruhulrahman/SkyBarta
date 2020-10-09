<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blood extends Model
{
    protected $table = 'bloods';
    protected $fillable = [
        'name',
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;

    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
