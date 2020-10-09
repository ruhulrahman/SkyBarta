<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermanentAddress extends Model
{
    protected $table = 'permanent_addresses';
    protected $fillable = [
        'user_id','division','district','police_station','postal','village',
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
