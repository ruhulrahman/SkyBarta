<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'incomes';
    protected $fillable = [
        'user_id','monthly_income',
    ];

    protected $primaryKey = 'id';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
