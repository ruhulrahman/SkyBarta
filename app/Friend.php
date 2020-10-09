<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friends';
    protected $fillable = [
        'user_id','request_id','accept_id',
    ];

    protected $primaryKey = 'id';
    
    public function sentuser()
    {
        return $this->belongsToMany(User::class, 'user_id');
    }
    public function request()
    {
        return $this->belongsTo(User::class, 'request_id');
    }

    public function accept()
    {
        return $this->belongsTo(User::class, 'accept_id');
    }
}
