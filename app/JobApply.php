<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobApply extends Model
{
    protected $table = 'job_applies';
    
    protected $fillable = [
        'job_id','applier_id',
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'applier_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
