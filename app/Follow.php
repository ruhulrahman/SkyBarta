<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follows';
    protected $fillable = [
        // 'user_id','follower_id', 'following_id',
        'following_id','follower_id',
    ];

    protected $primaryKey = 'id';
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
    public function followingPosts()
    {
        return $this->hasMany(Post::class, 'user_id', 'following_id');
    }
}
