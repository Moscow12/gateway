<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $table = 'clients';
    public $fillable = [
        'clientname',
        'clientemail',
        'clientphone',
        'clientaddress',
        'clientcity',
        'clientcountry',
        'added_by',
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(invoices::class, 'client_id');
    }
}
