<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';
    protected $fillable = [
        'name', 'division_id',
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function thanas()
    {
        return $this->hasMany(Thana::class);
    }
}
