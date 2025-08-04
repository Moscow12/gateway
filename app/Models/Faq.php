<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'category',
        'added_by',
        'created_at',
        'updated_at',
        'updated_by',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
