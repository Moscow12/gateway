<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'email', 'phone_number', 'address', 'Region_ID', 'District_ID', 'ward_id', 'street', 'zip_code', 'country', 'notes', 'National_Id', 'status', 'created_by'
    ];

}
