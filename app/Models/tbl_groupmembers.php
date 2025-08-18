<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_groupmembers extends Model
{
    protected $table = 'tbl_groupmembers'; // Specify the table name if it differs from the model name
    protected $fillable = [
        'group_id',
        'member_id', // Unique identifier for the member is id-group_id
        'role',
        'status',
        'joined_date', // Date when the member joined the group
        'left_date', // Date when the member left the group
        'member_name',
        'member_phone',
        'member_email' // Email address of the member
    ];

    // Define relationships with other models
    public function group()
    {
        return $this->belongsTo(tbl_groups::class);
    }

    public function penalty()
    {
        return $this->hasMany(penalties::class, 'member_id');
    }

    
}
