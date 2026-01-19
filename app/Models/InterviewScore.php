<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewScore extends Model
{
    protected $fillable = [
        'applicant_id',
        'criteria',
        'score',
        'max_score',
        'remarks',
        'scored_by',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'max_score' => 'decimal:2',
    ];

    public function applicant()
    {
        return $this->belongsTo(Jobapplications::class, 'applicant_id');
    }

    public function scorer()
    {
        return $this->belongsTo(User::class, 'scored_by');
    }

    public function getPercentageAttribute()
    {
        if ($this->max_score == 0) {
            return 0;
        }
        return round(($this->score / $this->max_score) * 100, 1);
    }
}
