<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class companydetail extends Model
{
    protected $table = 'companydetails';

    protected $fillable = [
        'company_name',
        'address',
        'phone',
        'email',
        'fax',
        'tax_number',
        'vat_number',
        'iban',
        'swift_bic',
        'bank_name',
        'bank_account',
        'bank_address',
        'website',
        'logo',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
