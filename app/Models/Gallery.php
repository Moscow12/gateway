<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['photo1', 'photo2', 'photo3', 'title', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
