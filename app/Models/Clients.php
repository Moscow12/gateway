<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $table = 'clients';
    public $fillable = [
        'clientcode',
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

    public function services()
    {
        return $this->hasMany(ClientService::class, 'client_id');
    }

    public function activeServices()
    {
        return $this->services()->where('status', ClientService::STATUS_ACTIVE);
    }
}
