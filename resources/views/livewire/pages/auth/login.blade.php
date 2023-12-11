<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest'), \Livewire\Attributes\Title('Login')] class extends Component
{
    public LoginForm $form;


    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirect(
            session('url.intended', RouteServiceProvider::HOME),
//            navigate: true
        );
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="card-body login-card-body">
        <p class="login-box-msg">{{ __('Login') }}</p>
        <form wire:submit="login">
        <!-- Email Address -->
            <div class="input-group mb-3">
                <input type="email" name="email" wire:model="form.email"
                       class="form-control @error('email') is-invalid @enderror"
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

            <!-- Password -->
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       wire:model="form.password"
                       placeholder="{{ __('Password') }}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                <span class="error invalid-feedback">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember" name="remember" wire:model="form.remember">
                        <label for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        @if (Route::has('password.request'))
        <div class="row mt-3">
            <div class="col-sm-6">
                <p class="mb-1">
                    <a href="{{ route('register') }}" wire:navigate>{{ __('Create Account?') }}</a>
                </p>
            </div>
            <div class="col-sm-6">
                <p class="mb-1">
                    <a href="{{ route('password.request') }}" wire:navigate>{{ __('Forgot Your Password?') }}</a>
                </p>
            </div>
        </div>
        @else
        <p class="mb-1">
            <a href="{{ route('password.request') }}" wire:navigate>{{ __('Forgot Your Password?') }}</a>
        </p>
       @endif

    </div>
</div>
