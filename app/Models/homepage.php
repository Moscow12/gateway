<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class homepage extends Model
{
    protected $fillable = [
        'headers',
        'title',
        'description',
        'background1',
        'background2',
        'background3',
        'added_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
