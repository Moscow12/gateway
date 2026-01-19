<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertvacancies extends Model
{
    protected $fillable = [
        'title',
        'description',
        'link',
        'requirements',
        'status',
        'location',
        'category',
        'created_by',
        'updated_by',
        'salary_min',
        'salary_max',
        'posted_at',
        'expires_at',
    ];

    public function applications()
    {
        return $this->hasMany(Jobapplications::class, 'vacancyID');
    }
}
