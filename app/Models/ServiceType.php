<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $table = 'service_types';

    protected $fillable = [
        'name',
        'description',
        'default_duration_months',
        'is_recurring',
        'base_price',
        'icon',
        'added_by',
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
        'base_price' => 'decimal:2',
        'default_duration_months' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function clientServices()
    {
        return $this->hasMany(ClientService::class);
    }

    public function activeServices()
    {
        return $this->clientServices()->where('status', 'active');
    }
}
