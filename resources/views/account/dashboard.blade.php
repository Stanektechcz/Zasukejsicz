@extends('layouts.account')

@section('title', __('front.account.dashboard.title'))

@php
    $activeItem = 'dashboard';
@endphp

@section('account-content')
    {{-- Email Not Verified Warning --}}
    @if (!auth()->user()->hasVerifiedEmail())
        <div class="mb-6 rounded-lg p-4 bg-red-50 border border-red-200">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-red-800 font-medium mb-2">
                        {{ __('Your email address is not verified.') }}
                    </p>
                    <p class="text-red-700 text-sm mb-3">
                        {{ __('Please check your inbox and click the verification link we sent you. If you didn\'t receive the email, you can request a new one.') }}
                    </p>
                    <form method="POST" action="{{ route('verification.send') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-800 hover:text-red-900 underline">
                            {{ __('Resend verification email') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Success/Status Messages --}}
    @if (session('status'))
        <div class="mb-6 rounded-lg p-4 {{ session('status') === 'email-verified' || session('status') === 'email-already-verified' || session('status') === 'password-updated' ? 'bg-green-50 border border-green-200' : 'bg-blue-50 border border-blue-200' }}">
            <div class="flex items-center">
                <svg class="w-5 h-5 {{ session('status') === 'email-verified' || session('status') === 'email-already-verified' || session('status') === 'password-updated' ? 'text-green-600' : 'text-blue-600' }} mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="{{ session('status') === 'email-verified' || session('status') === 'email-already-verified' || session('status') === 'password-updated' ? 'text-green-800' : 'text-blue-800' }} font-medium">
                    @if (session('status') === 'email-verified')
                        {{ __('Your email has been successfully verified!') }}
                    @elseif (session('status') === 'email-already-verified')
                        {{ __('Your email is already verified.') }}
                    @elseif (session('status') === 'verification-link-sent')
                        {{ __('A new verification link has been sent to your email address.') }}
                    @elseif (session('status') === 'password-updated')
                        {{ __('front.account.password.updated') }}
                    @else
                        {{ __(session('status')) }}
                    @endif
                </p>
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div class="mb-6 rounded-lg p-4 bg-yellow-50 border border-yellow-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-yellow-800 font-medium">{{ session('warning') }}</p>
            </div>
        </div>
    @endif

    <div class="mb-8">
        <h1 class="text-4xl font-semibold text-secondary py-6 text-center">
            {{ __('front.account.dashboard.basic_info') }}
        </h1>
        <hr>
    </div>

    @livewire('profile-form')

    <!-- Password Change Section -->
    <div class="mt-8 bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('front.account.password.title') }}</h3>
        <p class="text-sm text-gray-600 mb-6">{{ __('front.account.password.description') }}</p>
        
        <form method="POST" action="{{ route('account.password.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.account.password.current') }} *</label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    autocomplete="current-password"
                    class="input-control @error('current_password') border-red-500 @enderror"
                    required>
                @error('current_password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.account.password.new') }} *</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    class="input-control @error('password') border-red-500 @enderror"
                    required>
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.account.password.confirm') }} *</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    class="input-control"
                    required>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="btn-secondary btn-small justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    {{ __('front.account.password.update') }}
                </button>
            </div>
        </form>
    </div>
@endsection

