<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoiceitems extends Model
{
    protected $table = 'invoiceitems';
    protected $fillable = ['product_id', 'service_type_id', 'invoice_id', 'amount', 'description', 'quantity', 'added_by', 'Status', 'TotalAmount'];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function product()
    {
        return $this->belongsTo(Producties::class, 'product_id');
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    public function invoice()
    {
        return $this->belongsTo(invoices::class, 'invoice_id');
    }

    // Get the item name (service or product)
    public function getItemNameAttribute()
    {
        if ($this->serviceType) {
            return $this->serviceType->name;
        }
        if ($this->product) {
            return $this->product->productname;
        }
        return 'Unknown Item';
    }
}
