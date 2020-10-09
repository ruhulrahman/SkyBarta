<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
    protected $table = 'site_infos';
    protected $fillable = [
        'user_id','title','short_name', 'description'
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;
}
