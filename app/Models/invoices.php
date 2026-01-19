<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoices extends Model
{
    protected $table = 'invoices';
    protected $fillable = ['control_number', 'TotalAmount', 'Status', 'client_id', 'added_by', 'ControlNumberExpiretime', 'controlno_generatedtime'];

    protected $casts = [
        'ControlNumberExpiretime' => 'datetime',
        'controlno_generatedtime' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function invoiceitems()
    {
        return $this->hasMany(invoiceitems::class, 'invoice_id');
    }
}
