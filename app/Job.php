<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';
    
    protected $fillable = [
        'user_id','company_id','title','description','salary_range','deadline','category_id','privacy_id',
    ];

    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Profession::class, 'category_id');
    }

    public function privacy()
    {
        return $this->belongsTo(Privacy::class, 'privacy_id');
    }
}
