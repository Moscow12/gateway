<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fpattendances extends Model
{
    protected $fillable = [
        'device_id',
        'user_id',
        'timestamp',
        'status',
        'clockdate',
        'clocktime',
    ];
}
