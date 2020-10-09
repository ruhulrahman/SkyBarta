<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    
    //eager-load
    protected $with = ['user'];

    protected $fillable = [
        'post_id','user_id','comment',
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
