<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    protected $fillable = [
        'section_type',
        'title',
        'content',
        'image',
        'icon',
        'is_active',
        'order',
        'added_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    const TYPE_MISSION = 'mission';
    const TYPE_VISION = 'vision';
    const TYPE_HISTORY = 'history';
    const TYPE_WHY_CHOOSE_US = 'why_choose_us';
    const TYPE_VALUES = 'values';

    public static function getTypes()
    {
        return [
            self::TYPE_MISSION => 'Mission',
            self::TYPE_VISION => 'Vision',
            self::TYPE_HISTORY => 'History',
            self::TYPE_WHY_CHOOSE_US => 'Why Choose Us',
            self::TYPE_VALUES => 'Our Values',
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
        return $query->where('section_type', $type);
    }
}
