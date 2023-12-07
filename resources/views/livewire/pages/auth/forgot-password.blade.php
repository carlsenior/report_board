<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest'), \Livewire\Attributes\Title('Forgot')] class extends Component
{
    public string $email = '';

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

<div>
    <div class="card-body login-card-body">
        <p class="login-box-msg">{{ __('Reset Password') }}</p>
        <p class="login-box-msg" style="font-size: small">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   wire:model="email"
                   placeholder="{{ __('Email') }}" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
            <span class="error invalid-feedback">
                        {{ $message }}
                    </span>
            @enderror
        </div>

        <div class="row">
            <div class="col-12">
                <button type="submit"
                        class="btn btn-primary btn-block">{{ __('Send Password Reset Link') }}</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
    </div>
</div>
