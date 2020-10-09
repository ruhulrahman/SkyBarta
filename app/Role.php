<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'name',
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

}
