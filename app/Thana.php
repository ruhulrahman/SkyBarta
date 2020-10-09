<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{
    protected $table = 'thanas';
    protected $fillable = [
        'name', 'district_id',
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function division()
    {
        return $this->belongsToMany(Division::class, District::class, 'id','division_id','district_id','id');
    }
}
