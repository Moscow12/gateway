<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class ClientServiceSubscription extends Model
{
    protected $table = 'client_service_subscriptions';

    protected $fillable = [
        'client_service_id',
        'price',
        'billing_interval_months',
        'contract_attachment',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'billing_interval_months' => 'integer',
    ];

    public function clientService(): BelongsTo
    {
        return $this->belongsTo(ClientService::class, 'client_service_id');
    }

    /**
     * Generate a renewal invoice for a client's active recurring service.
     * Returns null (and logs a warning) if the client has no active recurring
     * service or no subscription configured for it — invoice generation is a
     * side effect, not a hard requirement for the renewal request to succeed.
     */
    public static function createRenewalInvoice(Clients $client, int $durationMonths): ?invoices
    {
        $clientService = ClientService::where('client_id', $client->id)
            ->where('status', ClientService::STATUS_ACTIVE)
            ->whereHas('serviceType', fn ($q) => $q->where('is_recurring', true))
            ->with(['subscription', 'serviceType'])
            ->first();

        if (!$clientService || !$clientService->subscription) {
            Log::warning("Skipped renewal invoice generation for client {$client->id}: no active recurring service with a configured subscription.");
            return null;
        }

        $subscription = $clientService->subscription;
        $amount = (float) $subscription->price * ($durationMonths / max(1, $subscription->billing_interval_months));

        $invoice = invoices::create([
            'client_id' => $client->id,
            'added_by' => $client->added_by,
        ]);

        invoiceitems::create([
            'invoice_id' => $invoice->id,
            'service_type_id' => $clientService->service_type_id,
            'description' => "License renewal - {$durationMonths} month(s)",
            'amount' => (string) $amount,
            'quantity' => '1',
            'added_by' => $client->added_by,
        ]);

        return $invoice;
    }
}
