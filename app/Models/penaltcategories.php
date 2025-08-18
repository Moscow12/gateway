<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penaltcategories extends Model
{
    protected $table = 'penaltycategories'; // Specify the table name if it differs from the model name
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

    public function penalties()
    {
        return $this->hasMany(penalties::class, 'penalty_category_id');
    }
}
