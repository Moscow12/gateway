<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_groups extends Model
{
    protected $table = 'tbl_groups'; // Specify the table name if it differs from the model name
    protected $fillable = [
        'name',
        'location',
        'region_id',
        'district_id',
        'ward',
        'village',
        'rep_phone',
        'rep_email',
        'rep_name', // Name of the group representative
        'group_type', // e.g., 'Savings', 'Investment', 'Social', etc.
        'group_status', // e.g., 'active', 'inactive', 'closed'
        'description' // Additional information about the group
    ];

    // Define relationships with other models
    public function region()
    {
        return $this->belongsTo(Regions::class);
    }

    public function district()
    {
        return $this->belongsTo(Districts::class);
    }

    public function members()
    {
        return $this->hasMany(tbl_groupmembers::class, 'group_id');
    }

    
}

// Add any additional methods or relationships as needed
// For example, if you want to define relationships with other models, you can do so here
