<x-mail::message>
# License Renewal Request Received

We have received your license renewal request for **{{ $renewalRequest->client->clientname }}**.

**Duration:** {{ $renewalRequest->duration_months }} month(s)
**Start Date:** {{ $renewalRequest->start_date->format('F j, Y') }}
**End Date:** {{ $renewalRequest->end_date->format('F j, Y') }}
**Phone Number:** {{ $renewalRequest->phone_number }}
@if($renewalRequest->commitment_comment)
**Commitment:** {{ $renewalRequest->commitment_comment }}
@endif

---

## Payment & Contact Details

@if($companyDetail)
**Account Name:** {{ $companyDetail->company_name }}
**Account Number:** {{ $companyDetail->bank_account }}
**Contact Number:** {{ $companyDetail->phone }}
@else
Please contact our office for payment and account details.
@endif

---

<small>This acknowledgment was generated on {{ $renewalRequest->created_at->format('F j, Y \a\t g:i A') }}</small>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
