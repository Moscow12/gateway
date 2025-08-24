<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoiceitems extends Model
{
    protected $table = 'invoiceitems';
    protected $fillable = ['product_id', 'invoice_id', 'amount', 'description', 'quantity','added_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function product()
    {
        return $this->belongsTo(Producties::class, 'product_id');
    }

    public function invoice()
    {
        return $this->belongsTo(invoices::class, 'invoice_id');
    }
}
