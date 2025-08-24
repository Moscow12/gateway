<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producties extends Model
{
    protected $table = 'products';
    protected $fillable = ['productname', 'initialprice', 'topprice', 'paymenttype', 'productdescription', 'added_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
