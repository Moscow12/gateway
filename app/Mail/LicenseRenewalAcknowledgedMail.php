<?php

namespace App\Mail;

use App\Models\LicenseRenewalRequest;
use App\Models\companydetail;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LicenseRenewalAcknowledgedMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public LicenseRenewalRequest $renewalRequest,
        public ?companydetail $companyDetail = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'License Renewal Request Received',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.license-renewal-acknowledged',
            with: [
                'renewalRequest' => $this->renewalRequest,
                'companyDetail' => $this->companyDetail,
            ],
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
