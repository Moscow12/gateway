<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClientService extends Model
{
    protected $table = 'client_services';

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_LICENSE_EXPIRED = 'license_expired';
    const STATUS_PENDING = 'pending';
    const STATUS_SUSPENDED = 'suspended';

    public static $statuses = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_LICENSE_EXPIRED => 'License Expired',
        self::STATUS_PENDING => 'Pending',
        self::STATUS_SUSPENDED => 'Suspended',
    ];

    protected $fillable = [
        'client_id',
        'service_type_id',
        'status',
        'license_start_date',
        'license_end_date',
        'notes',
        'last_maintenance_date',
        'next_renewal_date',
        'contract_reference',
        'added_by',
    ];

    protected $casts = [
        'license_start_date' => 'date',
        'license_end_date' => 'date',
        'last_maintenance_date' => 'date',
        'next_renewal_date' => 'date',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_LICENSE_EXPIRED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeSuspended($query)
    {
        return $query->where('status', self::STATUS_SUSPENDED);
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('status', self::STATUS_ACTIVE)
            ->whereNotNull('license_end_date')
            ->whereBetween('license_end_date', [Carbon::today(), Carbon::today()->addDays($days)]);
    }

    // Helpers
    public function getDaysLeftAttribute()
    {
        if (!$this->license_end_date) {
            return null;
        }

        $today = Carbon::today();
        $endDate = Carbon::parse($this->license_end_date);

        if ($endDate->isPast()) {
            return 0;
        }

        return $today->diffInDays($endDate);
    }

    public function isExpiringSoon($days = 30)
    {
        if (!$this->license_end_date) {
            return false;
        }

        $endDate = Carbon::parse($this->license_end_date);
        return $endDate->isBetween(Carbon::today(), Carbon::today()->addDays($days));
    }

    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'bg-success bg-opacity-10 text-success',
            self::STATUS_INACTIVE => 'bg-secondary bg-opacity-10 text-secondary',
            self::STATUS_LICENSE_EXPIRED => 'bg-danger bg-opacity-10 text-danger',
            self::STATUS_PENDING => 'bg-warning bg-opacity-10 text-warning',
            self::STATUS_SUSPENDED => 'bg-dark bg-opacity-10 text-dark',
            default => 'bg-secondary bg-opacity-10 text-secondary',
        };
    }

    public function getStatusIconAttribute()
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'bx-check-circle',
            self::STATUS_INACTIVE => 'bx-pause-circle',
            self::STATUS_LICENSE_EXPIRED => 'bx-x-circle',
            self::STATUS_PENDING => 'bx-time-five',
            self::STATUS_SUSPENDED => 'bx-block',
            default => 'bx-help-circle',
        };
    }
}
