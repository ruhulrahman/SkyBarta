<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    protected $table = 'user_education';
    protected $fillable = [
        'user_id', 'degree_id','major_id','passing_year',
    ];

    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }
    
    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
