<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    //eager-load
    protected $with = ['privacy'];

    protected $fillable = [
        'user_id','desc','privacy_id',
    ];

    protected $primaryKey = 'id';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function privacy()
    {
        return $this->belongsTo(Privacy::class);
    }

    
    public function like()
    {
        return $this->belongsTo(Like::class);
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderby('id', 'desc');
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class);
    }


}
