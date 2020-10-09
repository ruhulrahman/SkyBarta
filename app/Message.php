<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];
    // protected $table = 'messages';
    // protected $fillable = [
    //     'from','to', 'text',
    // ];

    public function fromContact()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }

    // public function from()
    // {
    //     return $this->belongsTo(User::class, 'from');
    // }
    // public function to()
    // {
    //     return $this->belongsTo(User::class, 'to');
    // }
}
