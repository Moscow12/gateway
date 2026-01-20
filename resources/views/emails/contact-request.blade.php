<x-mail::message>
# New Contact Request

You have received a new contact request from your website.

**From:** {{ $contactRequest->name }}
**Email:** {{ $contactRequest->email }}
@if($contactRequest->phone)
**Phone:** {{ $contactRequest->phone }}
@endif
@if($contactRequest->company)
**Company:** {{ $contactRequest->company }}
@endif
**Subject:** {{ $contactRequest->subject }}

---

## Message

{{ $contactRequest->message }}

---

<x-mail::button :url="route('contact-requests')">
View in Dashboard
</x-mail::button>

<small>This request was submitted on {{ $contactRequest->created_at->format('F j, Y \a\t g:i A') }}</small>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
