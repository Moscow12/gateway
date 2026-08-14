<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\LicenseRenewalAcknowledgedMail;
use App\Models\Clients;
use App\Models\ClientServiceSubscription;
use App\Models\companydetail;
use App\Models\LicenseRenewalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LicenseRenewalController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'secretkey' => 'required|string',
            'duration_months' => 'required|integer|min:1',
            'phone_number' => 'required|string|max:20',
            'commitment_comment' => 'nullable|string',
        ]);

        $client = Clients::where('secretkey', $validated['secretkey'])->first();

        if (!$client) {
            return response()->json([
                'message' => 'Invalid secret key. Please check your key and try again, or contact HosPi System Support.',
            ], 401);
        }

        $existingRequest = LicenseRenewalRequest::where('client_id', $client->id)
            ->where('duration_months', $validated['duration_months'])
            ->whereIn('status', [LicenseRenewalRequest::STATUS_PENDING, LicenseRenewalRequest::STATUS_ACKNOWLEDGED])
            ->first();

        if ($existingRequest) {
            $companyDetail = companydetail::first();

            return response()->json([
                'message' => 'Your request already received, waiting for acknowledgement, or contact HosPi System Support to resolve the issue.',
                'renewal_request' => $existingRequest,
                'company_details' => [
                    'account_number' => $companyDetail->bank_account ?? null,
                    'account_name' => $companyDetail->company_name ?? null,
                    'bank_name' => $companyDetail->bank_name ?? null,
                    'contact_number' => $companyDetail->phone ?? null,
                ],
            ], 200);
        }

        $startDate = now()->startOfDay();
        $endDate = $startDate->copy()->addMonths($validated['duration_months']);

        $renewalRequest = LicenseRenewalRequest::create([
            'client_id' => $client->id,
            'duration_months' => $validated['duration_months'],
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'phone_number' => $validated['phone_number'],
            'commitment_comment' => $validated['commitment_comment'] ?? null,
            'status' => LicenseRenewalRequest::STATUS_ACKNOWLEDGED,
            'acknowledged_at' => now(),
        ]);

        $companyDetail = companydetail::first();

        try {
            if ($renewalRequest->client && $renewalRequest->client->clientemail) {
                Mail::to($renewalRequest->client->clientemail)
                    ->send(new LicenseRenewalAcknowledgedMail($renewalRequest, $companyDetail));
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send license renewal acknowledgment email: ' . $e->getMessage());
        }

        $invoice = null;
        try {
            $invoice = ClientServiceSubscription::createRenewalInvoice($client, $validated['duration_months']);
        } catch (\Throwable $e) {
            Log::error('Failed to generate renewal invoice: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'License renewal request received and acknowledged',
            'renewal_request' => $renewalRequest,
            'invoice_id' => $invoice?->id,
            'company_details' => [
                'account_number' => $companyDetail->bank_account ?? null,
                'account_name' => $companyDetail->company_name ?? null,
                'bank_name' => $companyDetail->bank_name ?? null,
                'contact_number' => $companyDetail->phone ?? null,
            ],
        ], 201);
    }
}
