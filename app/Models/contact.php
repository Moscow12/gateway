<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    protected $fillable = [
        'address',
        'phone',
        'fax',
        'email',
        'facebook',
        'instagram',
        'tweeter',
        'whatsapp',
        'youtube',
        'added_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
