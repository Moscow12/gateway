<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class groupcontributioncategory extends Model
{
    protected $table = 'groupcontributioncategory';
    protected $fillable = [
        'name',
        'description',
        'group_id',
        'added_by',
        'updated_by'
    ];

    public function group()
    {
        return $this->belongsTo(tbl_groups::class);
    }

    public function members()
    {
        return $this->hasMany(tbl_groupmembers::class, 'group_id');
    }
}
