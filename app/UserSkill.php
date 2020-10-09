<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    protected $table = 'user_skills';
    protected $fillable = [
        'user_id','skill_id'
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
