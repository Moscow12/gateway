<?php

use App\Livewire\Forms\LoginForm;
use App\Models\companydetail;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component
{
    public LoginForm $form;

    public ?companydetail $company = null;

    public function mount(): void
    {
        $this->company = companydetail::first();
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
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
                <p class="hp-side-tagline">Welcome back — sign in to manage your portal.</p>
            </div>
        </aside>

        <!-- Login form -->
        <div class="hp-auth-card">
        <!-- Brand (mobile) -->
        <div class="text-center mb-4">
            <img src="{{ $logoSrc }}" width="64" alt="{{ $companyName }} logo" class="hp-auth-logo mb-3 d-lg-none">
            <h3 class="hp-auth-title">👋 Welcome back</h3>
            <p class="hp-auth-subtitle">Please log in to your account</p>
        </div>

        <!-- Validation errors -->
        @if ($errors->any())
            <div class="hp-alert" role="alert">
                <i class="bx bx-error-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form wire:submit="login">
            <!-- Email -->
            <div class="hp-field">
                <label for="email" class="hp-label">Email</label>
                <input type="email"
                       id="email"
                       wire:model="form.email"
                       class="hp-input @error('form.email') is-invalid @enderror"
                       placeholder="Enter your email"
                       required autofocus autocomplete="username">
            </div>

            <!-- Password (with show/hide) -->
            <div class="hp-field" x-data="{ show: false }">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="password" class="hp-label">Password</label>
                    <a href="{{ route('password.request') }}" wire:navigate class="hp-link-sm">Forgot password?</a>
                </div>
                <div class="hp-input-group">
                    <input :type="show ? 'text' : 'password'"
                           id="password"
                           wire:model="form.password"
                           class="hp-input @error('form.password') is-invalid @enderror"
                           placeholder="Enter your password"
                           required autocomplete="current-password">
                    <button type="button"
                            class="hp-toggle"
                            @click="show = !show"
                            :aria-label="show ? 'Hide password' : 'Show password'"
                            tabindex="-1">
                        <i class="bx" :class="show ? 'bx-show' : 'bx-hide'"></i>
                    </button>
                </div>
            </div>

            <!-- Remember me -->
            <div class="hp-field">
                <label class="hp-checkbox">
                    <input type="checkbox" wire:model="form.remember">
                    <span>Remember me</span>
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" class="hp-btn-primary" wire:loading.attr="disabled" wire:target="login">
                <span wire:loading.remove wire:target="login">Sign in</span>
                <span wire:loading wire:target="login">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Signing in...
                </span>
            </button>

            <!-- Sign up -->
            <p class="hp-auth-footer">
                Don't have an account yet?
                <a href="{{ route('register') }}" wire:navigate>Sign up here</a>
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
        .hp-input.is-invalid {
            border-color: #ef4444;
        }
        .hp-input-group { position: relative; }
        .hp-input-group .hp-input { padding-right: 46px; }
        .hp-toggle {
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: 44px;
            border: none;
            background: transparent;
            color: #6b7280;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
        }
        .hp-toggle:hover { color: #111827; }
        .hp-checkbox {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: #374151;
            cursor: pointer;
            margin-bottom: 0;
        }
        .hp-checkbox input {
            width: 16px;
            height: 16px;
            accent-color: #3b82f6;
            cursor: pointer;
        }
        .hp-link-sm {
            font-size: 0.85rem;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }
        .hp-link-sm:hover { text-decoration: underline; }
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
        [wire\:cloak] { display: none; }
    </style>
</div>
