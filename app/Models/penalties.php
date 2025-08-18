<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penalties extends Model
{
    protected $table = 'penalties'; // Specify the table name if it differs from the model name
    protected $fillable = [
        'member_id',
        'group_id',
        'penalty_category_id',
        'status',
        'description',
        'added_by'
    ];

    public function member()
    {
        return $this->belongsTo(tbl_groupmembers::class);
    }

    public function group()
    {
        return $this->belongsTo(tbl_groups::class);
    }

    public function penalty_category()
    {
        return $this->belongsTo(penaltcategories::class);
    }
}
