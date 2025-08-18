<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsConditions extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
