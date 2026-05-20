<?php

use App\Models\companydetail;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component
{
    public string $email = '';

    public ?companydetail $company = null;

    public function mount(): void
    {
        $this->company = companydetail::first();
    }

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

@php
    $companyName = $company?->company_name ?? config('app.name', 'HR Portal');
    $logoSrc = $company?->logo
        ? asset('storage/' . $company->logo)
        : asset('admin/images/logo.jpg');
@endphp
<div class="hp-auth">
    <div class="hp-auth-shell" wire:cloak>
        <!-- Brand sidebar -->
        <aside class="hp-auth-side">
            <div class="hp-side-inner">
                <img src="{{ $logoSrc }}" alt="{{ $companyName }} logo" class="hp-side-logo">
                <h2 class="hp-side-name">{{ $companyName }}</h2>
                @if($company?->website)
                    <a href="{{ $company->website }}" target="_blank" rel="noopener" class="hp-side-link">{{ $company->website }}</a>
                @endif
                <p class="hp-side-tagline">No worries — we'll help you get back into your account.</p>
            </div>
        </aside>

        <!-- Forgot password form -->
        <div class="hp-auth-card">
            <!-- Brand (mobile) -->
            <div class="text-center mb-4">
                <img src="{{ $logoSrc }}" width="64" alt="{{ $companyName }} logo" class="hp-auth-logo mb-3 d-lg-none">
                <h3 class="hp-auth-title">🔑 Forgot password?</h3>
                <p class="hp-auth-subtitle">Enter your email and we'll send you a reset link.</p>
            </div>

            <!-- Session status -->
            @if (session('status'))
                <div class="hp-alert hp-alert-success" role="alert">
                    <i class="bx bx-check-circle"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Validation errors -->
            @if ($errors->any())
                <div class="hp-alert" role="alert">
                    <i class="bx bx-error-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form wire:submit="sendPasswordResetLink">
                <!-- Email -->
                <div class="hp-field">
                    <label for="email" class="hp-label">Email</label>
                    <input type="email"
                           id="email"
                           wire:model="email"
                           class="hp-input @error('email') is-invalid @enderror"
                           placeholder="Enter your email"
                           required autofocus autocomplete="username">
                </div>

                <!-- Submit -->
                <button type="submit" class="hp-btn-primary" wire:loading.attr="disabled" wire:target="sendPasswordResetLink">
                    <span wire:loading.remove wire:target="sendPasswordResetLink">Email password reset link</span>
                    <span wire:loading wire:target="sendPasswordResetLink">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        Sending...
                    </span>
                </button>

                <!-- Back to login -->
                <p class="hp-auth-footer">
                    Remember your password?
                    <a href="{{ route('login') }}" wire:navigate>Back to log in</a>
                </p>
            </form>
        </div>
    </div>

    <style>
        .hp-auth {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: linear-gradient(160deg, #cfe5fb 0%, #a9cdf3 45%, #8bb9ec 100%);
            font-family: 'Roboto', system-ui, -apple-system, sans-serif;
        }
        .hp-auth-shell {
            width: 100%;
            max-width: 880px;
            display: flex;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(40, 80, 140, 0.18);
        }
        .hp-auth-side {
            display: none;
            flex: 0 0 42%;
            background: linear-gradient(160deg, #1f2937 0%, #111827 100%);
            color: #fff;
            padding: 48px 36px;
            align-items: center;
            justify-content: center;
        }
        .hp-side-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
        }
        .hp-side-logo {
            width: 96px;
            height: 96px;
            object-fit: cover;
            border-radius: 18px;
            background: #fff;
            padding: 6px;
            margin-bottom: 20px;
        }
        .hp-side-name {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 6px;
        }
        .hp-side-link {
            color: #93c5fd;
            text-decoration: none;
            font-size: 0.9rem;
            word-break: break-all;
        }
        .hp-side-link:hover { text-decoration: underline; }
        .hp-side-tagline {
            color: #cbd5e1;
            font-size: 0.95rem;
            margin-top: 18px;
            margin-bottom: 0;
            line-height: 1.5;
        }
        @media (min-width: 992px) {
            .hp-auth-side { display: flex; }
        }
        .hp-auth-card {
            flex: 1;
            width: 100%;
            background: #fff;
            padding: 40px 36px;
        }
        .hp-auth-logo {
            border-radius: 14px;
            object-fit: cover;
        }
        .hp-auth-title {
            font-weight: 700;
            font-size: 1.6rem;
            color: #111827;
            margin-bottom: 4px;
        }
        .hp-auth-subtitle {
            color: #6b7280;
            margin-bottom: 0;
            font-size: 0.95rem;
        }
        .hp-field { margin-bottom: 18px; }
        .hp-label {
            display: block;
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 6px;
        }
        .hp-input {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 0.95rem;
            color: #111827;
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }
        .hp-input::placeholder { color: #9ca3af; }
        .hp-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .hp-input.is-invalid { border-color: #ef4444; }
        .hp-btn-primary {
            width: 100%;
            border: none;
            border-radius: 12px;
            background: #111827;
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 13px;
            margin-top: 4px;
            cursor: pointer;
            transition: background 0.15s, transform 0.05s;
        }
        .hp-btn-primary:hover { background: #1f2937; }
        .hp-btn-primary:active { transform: translateY(1px); }
        .hp-btn-primary:disabled { opacity: 0.7; cursor: not-allowed; }
        .hp-auth-footer {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 0;
            font-size: 0.9rem;
            color: #6b7280;
        }
        .hp-auth-footer a {
            color: #3b82f6;
            font-weight: 600;
            text-decoration: none;
        }
        .hp-auth-footer a:hover { text-decoration: underline; }
        .hp-alert {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 0.875rem;
            margin-bottom: 18px;
        }
        .hp-alert i { font-size: 1.1rem; flex-shrink: 0; }
        .hp-alert-success {
            background: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }
        [wire\:cloak] { display: none; }
    </style>
</div>
