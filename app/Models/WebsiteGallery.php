<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteGallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'title',
        'description',
        'image',
        'category',
        'is_active',
        'order',
        'added_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    const CATEGORY_PROJECTS = 'projects';
    const CATEGORY_TEAM = 'team';
    const CATEGORY_OFFICE = 'office';
    const CATEGORY_EVENTS = 'events';

    public static function getCategories()
    {
        return [
            self::CATEGORY_PROJECTS => 'Projects',
            self::CATEGORY_TEAM => 'Team',
            self::CATEGORY_OFFICE => 'Office',
            self::CATEGORY_EVENTS => 'Events',
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

    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
