@extends('layouts.app')

@section('title', 'Register')

@section('content')
<!-- Add top padding to account for fixed navbar -->
<div class="pt-28 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="p-10 rounded-3xl max-w-2xl w-full space-y-8 border-2 border-gray-200">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-text-default">
                {{ __('Create your account') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Join us and discover amazing massage therapists.') }}
            </p>
        </div>

        <div class="px-8 pt-2">
            <form class="space-y-5" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name">{{ __('Full Name') }}</label>
                    <input id="name" name="name" type="text" autocomplete="name" required
                        class="input-control mt-1 @error('name') border-red-500 @enderror"
                        placeholder="{{ __('Enter your full name') }}"
                        value="{{ old('name') }}">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email">{{ __('Email Address') }}</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="input-control mt-1 @error('email') border-red-500 @enderror"
                        placeholder="{{ __('Enter your email address') }}"
                        value="{{ old('email') }}">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone">{{ __('Phone Number') }} ({{ __('Optional') }})</label>
                    <input id="phone" name="phone" type="tel" autocomplete="tel"
                        class="input-control mt-1 @error('phone') border-red-500 @enderror"
                        placeholder="{{ __('Enter your phone number') }}"
                        value="{{ old('phone') }}">
                    @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="input-control mt-1 @error('password') border-red-500 @enderror"
                        placeholder="{{ __('Enter your password') }}">
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                        class="input-control mt-1 @error('password_confirmation') border-red-500 @enderror"
                        placeholder="{{ __('Confirm your password') }}">
                    @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms and Submit Button -->
                <div class="w-full flex items-center justify-between space-x-6">
                    <div class="text-xs text-gray-600 max-w-xs">
                        {{ __('By creating an account, you agree to our') }}
                        <br/>
                        <a href="#" class="text-primary-600 hover:text-primary-500">{{ __('Terms of Service') }}</a>
                        {{ __('and') }}
                        <a href="#" class="text-primary-600 hover:text-primary-500">{{ __('Privacy Policy') }}</a>.
                    </div>
                    <button type="submit" class="btn-primary btn-small justify-center">
                        {{ __('Create account') }}
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center pt-6">
                    <p class="text-sm text-gray-600">
                        {{ __('Already have an account?') }}
                        <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                            {{ __('Sign in here') }}
                        </a>
                    </p>
                </div>


            </form>
        </div>
    </div>
</div>
@endsection