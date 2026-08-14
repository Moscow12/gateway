<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LicenseRenewalRequest extends Model
{
    protected $table = 'license_renewal_requests';

    const STATUS_PENDING = 'pending';
    const STATUS_ACKNOWLEDGED = 'acknowledged';
    const STATUS_COMPLETED = 'completed';
    const STATUS_REJECTED = 'rejected';
    const STATUS_APPROVED = 'approved';
    const STATUS_PROCESSED = 'processed';

    protected $fillable = [
        'client_id',
        'duration_months',
        'start_date',
        'end_date',
        'phone_number',
        'commitment_comment',
        'status',
        'acknowledged_at',
        'invoice_id',
        'client_service_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'acknowledged_at' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(invoices::class, 'invoice_id');
    }

    public function clientService(): BelongsTo
    {
        return $this->belongsTo(ClientService::class, 'client_service_id');
    }
}
