<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'website',
        'description',
        'partner_type',
        'is_active',
        'order',
        'added_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    const TYPE_PARTNER = 'partner';
    const TYPE_SPONSOR = 'sponsor';
    const TYPE_CLIENT = 'client';

    public static function getTypes()
    {
        return [
            self::TYPE_PARTNER => 'Partner',
            self::TYPE_SPONSOR => 'Sponsor',
            self::TYPE_CLIENT => 'Client',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('partner_type', $type);
    }
}
