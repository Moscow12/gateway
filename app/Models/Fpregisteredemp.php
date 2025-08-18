<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fpregisteredemp extends Model
{
    protected $fillable = [
        'name',
        'acc_no',
    ];

    /**
     * Get the attendances for the registered employee.
     */
    public function attendances()
    {
        return $this->hasMany(Fpattendances::class, 'user_id', 'acc_no');
    }
}
