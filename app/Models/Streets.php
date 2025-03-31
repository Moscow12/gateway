<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Streets extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'ward_id'];

    public function wards()
    {
        return $this->belongsTo(Wards::class);
    }
}
