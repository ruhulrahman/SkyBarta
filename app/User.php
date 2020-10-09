<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'slug', 'email', 'mobile', 'password', 'role_id', 'aboutme', 
        'gender_id', 'dob', 'm_income', 'fam_members','blood_id', 'profession_id', 
        'photo','hobby','religion_id','relation_id','quote',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function blood(){
        return $this->belongsTo(Blood::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function gender(){
        return $this->belongsTo(Gender::class);
    }

    public function religion(){
        return $this->belongsTo(Religion::class, 'religion_id');
    }

    public function relation(){
        return $this->belongsTo(Relation::class);
    }

    public function profession(){
        return $this->belongsTo(Profession::class);
    }

    public function follow(){
        $auth_id = auth('api')->user()->id;
        return $this->belongsTo(Follow::class, 'follower_id', $auth_id);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function friends(){
        return $this->hasMany(Friend::class, 'user_id', 'id');
    }

    public function friend(){
        return $this->hasOne(Friend::class, 'user_id', 'id');
    }

    public function requests(){
        return $this->hasMany(Friend::class, 'request_id', 'id');
    }

    public function followings(){
        return $this->hasMany(Follow::class, 'follower_id', 'id');
    }

    public function followers(){
        return $this->hasMany(Follow::class, 'following_id', 'id');
    }

    public function degree(){
        return $this->hasMany(Degree::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }


}
