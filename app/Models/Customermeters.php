<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customermeters extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'meter_name', 'meter_type', 'meter_value', 'meter_unit', 'meter_number', 'dateconnected', 'address', 'Region_ID', 'District_ID', 'ward_id', 'street', 'emegence_contacts', 'longitudinal', 'latitude', 'created_by'
    ];
}
