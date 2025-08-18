<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abouts extends Model
{
    protected $fillable = ['user_id', 'why_us', 'what_we_do', 'what_we_offer', 'our_mission', 'our_goals', 'our_values', 'safari_package', 'selling_package', 'bookingprocess', 'photo'];

    protected $casts = [
        'safari_package' => 'array',
        'selling_package' => 'array',
        'photo' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


