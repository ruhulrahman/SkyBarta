<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    protected $table = 'relations';
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
