@extends('layouts.member')

@section('member-content')
<!-- Breadcrumb -->
<nav class="flex mb-8" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('profiles.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                {{ __('front.nav.home') }}
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ __('front.account.member.settings') }}</span>
            </div>
        </li>
    </ol>
</nav>

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
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-medium text-gray-900">{{ __('front.account.password.title') }}</h3>
            <p class="mt-1 text-sm text-gray-600">{{ __('front.account.password.description') }}</p>
        </div>
        <a href="{{ route('account.member.password.edit') }}" class="btn-secondary btn-small">
            {{ __('front.account.password.update') }}
        </a>
    </div>
</div>
@endsection
