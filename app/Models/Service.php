<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'icon',
        'image',
        'features',
        'price_from',
        'price_to',
        'price_unit',
        'is_featured',
        'is_active',
        'order',
        'added_by',
    ];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price_from' => 'decimal:2',
        'price_to' => 'decimal:2',
    ];

    // Auto-generate slug from name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('name') && empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    // Helpers
    public function getPriceRangeAttribute()
    {
        if ($this->price_from && $this->price_to) {
            return 'TZS ' . number_format($this->price_from) . ' - ' . number_format($this->price_to);
        } elseif ($this->price_from) {
            return 'From TZS ' . number_format($this->price_from);
        } elseif ($this->price_to) {
            return 'Up to TZS ' . number_format($this->price_to);
        }
        return 'Contact for pricing';
    }

    public function getPriceUnitLabelAttribute()
    {
        return match ($this->price_unit) {
            'hour' => 'per hour',
            'month' => 'per month',
            'year' => 'per year',
            default => 'per project',
        };
    }
}
