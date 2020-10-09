<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PresentAddress extends Model
{
    protected $table = 'posts';
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
