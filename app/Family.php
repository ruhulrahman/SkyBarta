<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $table = 'familes';
    protected $fillable = [
        'user_id','member_id',
    ];

    protected $primaryKey = 'id';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
