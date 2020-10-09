<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';
    protected $fillable = [
        'user_id','role_id'
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
