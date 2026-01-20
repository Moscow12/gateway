<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'status',
        'priority',
        'acknowledged_by',
        'acknowledged_at',
        'notes',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'acknowledged_at' => 'datetime',
    ];

    /**
     * Status options
     */
    public const STATUSES = [
        'new' => 'New',
        'in_progress' => 'In Progress',
        'resolved' => 'Resolved',
        'closed' => 'Closed',
    ];

    /**
     * Priority options
     */
    public const PRIORITIES = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
    ];

    /**
     * Get the user who acknowledged this request
     */
    public function acknowledgedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'acknowledged_by');
    }

    /**
     * Scope for new requests
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope for unresolved requests
     */
    public function scopeUnresolved($query)
    {
        return $query->whereIn('status', ['new', 'in_progress']);
    }

    /**
     * Check if request is new
     */
    public function isNew(): bool
    {
        return $this->status === 'new';
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'new' => 'primary',
            'in_progress' => 'warning',
            'resolved' => 'success',
            'closed' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Get priority badge color
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'high' => 'danger',
            'medium' => 'warning',
            'low' => 'info',
            default => 'secondary',
        };
    }
}
