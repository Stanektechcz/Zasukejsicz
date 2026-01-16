@extends('layouts.member')

@section('member-content')
<!-- Page Title -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">{{ __('front.account.member.settings') }}</h1>
    <p class="mt-2 text-sm text-gray-600">{{ __('front.account.member.settings_description') }}</p>
</div>

<!-- Status Messages -->
@if (session('status') === 'settings-updated')
    <div class="alert alert-success flex items-center justify-between mb-6">
        <div class="flex items-center font-semibold">
            <x-icons name="bell" class="w-5 h-5 mr-2.5" />
            <span>{{ __('front.account.member.settings_saved') }}</span>
        </div>
        <button type="button" class="flex items-center ml-2 text-gray-400 hover:text-gray-600" onclick="this.parentElement.remove()">
            <x-icons name="cross" class="text-green-800 w-3 h-3" />
        </button>
    </div>
@endif

@if (session('status') === 'password-updated')
    <div class="alert alert-success flex items-center justify-between mb-6">
        <div class="flex items-center font-semibold">
            <x-icons name="bell" class="w-5 h-5 mr-2.5" />
            <span>{{ __('front.account.password.updated') }}</span>
        </div>
        <button type="button" class="flex items-center ml-2 text-gray-400 hover:text-gray-600" onclick="this.parentElement.remove()">
            <x-icons name="cross" class="text-green-800 w-3 h-3" />
        </button>
    </div>
@endif

<!-- User Settings Form -->
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <form method="POST" action="{{ route('account.member.settings.update') }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.name') }} *</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="input-control @error('name') border-red-500 @enderror"
                required>
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.email') }} *</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                class="input-control @error('email') border-red-500 @enderror"
                required>
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.phone') }}</label>
            <input
                type="tel"
                id="phone"
                name="phone"
                value="{{ old('phone', $user->phone) }}"
                class="input-control @error('phone') border-red-500 @enderror">
            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="btn-primary btn-small justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ __('front.profiles.form.savechanges') }}
            </button>
        </div>
    </form>
</div>

<!-- Password Change Link -->
<div class="mt-6 bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('front.account.password.title') }}</h3>
    <p class="text-sm text-gray-600 mb-6">{{ __('front.account.password.description') }}</p>
    
    <form method="POST" action="{{ route('account.member.password.update') }}" class="space-y-4">
        @csrf
        @method('PATCH')

        <!-- Current Password -->
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.account.password.current') }} *</label>
            <input
                type="password"
                id="current_password"
                name="current_password"
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
