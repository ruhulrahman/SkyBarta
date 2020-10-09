<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = [
        'user_id','name','address','email'
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
