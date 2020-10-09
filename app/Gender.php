<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $table = 'genders';
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
