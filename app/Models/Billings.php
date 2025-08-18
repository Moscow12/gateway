<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billings extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'bill_name', 'bill_type', 'bill_value', 'bill_unit', 'bill_number', 'datebilled', 'address', 'Region_ID', 'District_ID', 'ward_id', 'street', 'emegence_contacts', 'longitudinal', 'latitude', 'created_by'
    ];
}
