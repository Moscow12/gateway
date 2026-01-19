<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Jobapplications extends Model
{
    protected $fillable = [
        'vacancyID',
        'ApplicantName',
        'ApplicantEmail',
        'phone',
        'Gender',
        'MaritalStatus',
        'Nida',
        'dob',
        'Location',
        'status',
        'Remarks',
        'fourFourCert',
        'internshipCert',
        'birthCert',
        'sixCertificate',
        'mctCertificate',
        'license',
        'CariculumVitae',
        'collageCert',
        'applicationLetter'
    ];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->dob)->age;
    }

    public function vacancy()
    {
        return $this->belongsTo(Advertvacancies::class, 'vacancyID');
    }

    public function scores()
    {
        return $this->hasMany(InterviewScore::class, 'applicant_id');
    }

    public function getTotalScoreAttribute()
    {
        return $this->scores->sum('score');
    }

    public function getMaxPossibleScoreAttribute()
    {
        return $this->scores->sum('max_score');
    }

    public function getAveragePercentageAttribute()
    {
        if ($this->maxPossibleScore == 0) {
            return 0;
        }
        return round(($this->totalScore / $this->maxPossibleScore) * 100, 1);
    }
}
