<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Jobapplications extends Model
{
    protected $fillable = [
        'ApplicantName', 
        'ApplicantEmail', 
        'phone', 
        'Gender', 
        'MaritalStatus', 
        'Nida', 
        'dob', 
        'Location',
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

}
