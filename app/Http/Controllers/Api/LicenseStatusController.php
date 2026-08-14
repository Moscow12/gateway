<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\LicenseRenewalRequest;
use Illuminate\Http\Request;

class LicenseStatusController extends Controller
{
    public function show(Request $request)
    {
        $validated = $request->validate([
            'secretkey' => 'required|string',
        ]);

        $client = Clients::where('secretkey', $validated['secretkey'])->first();

        if (!$client) {
            return response()->json([
                'message' => 'Invalid secret key. Please check your key and try again, or contact HosPi System Support.',
            ], 401);
        }

        $renewalRequest = LicenseRenewalRequest::where('client_id', $client->id)
            ->with(['invoice.invoiceitems', 'clientService'])
            ->latest('created_at')
            ->first();

        if (!$renewalRequest) {
            return response()->json([
                'message' => 'No license renewal request found for this client.',
                'renewal_status' => null,
                'license_status' => null,
                'license_amount' => null,
            ], 200);
        }

        $licenseAmount = $renewalRequest->invoice->TotalAmount
            ?? $renewalRequest->invoice?->invoiceitems->sum('amount')
            ?? null;

        return response()->json([
            'renewal_status' => $renewalRequest->status,
            'license_status' => $renewalRequest->clientService->status ?? null,
            'license_amount' => $licenseAmount,
        ], 200);
    }
}
