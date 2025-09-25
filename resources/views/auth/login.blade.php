@extends('layouts.app')

@section('title', 'Login')

@section('content')
<!-- Add top padding to account for fixed navbar -->
<div class="pt-28 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="p-10 rounded-3xl max-w-2xl w-full space-y-8 border-2 border-gray-200">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-text-default">
                {{ __('Sign in to your account') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Welcome back! Please sign in to continue.') }}
            </p>
        </div>

        <div class="p-8">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email">{{ __('Email address') }}</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="input-control mt-1 @error('email') border-red-500 @enderror" 
                           placeholder="{{ __('Enter your email') }}" 
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           class="input-control mt-1 @error('password') border-red-500 @enderror" 
                           placeholder="{{ __('Enter your password') }}">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me and Submit Button -->
                <div class="w-full flex items-center justify-between space-x-6">
                    <div class="flex items-center justify-start flex-grow-1 max-w-sm">
                        <div class="-translate-y-px">
                            <input id="remember" name="remember" type="checkbox" 
                                   {{ old('remember') ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        </div>
                        <label for="remember" class="ml-2 block text-sm text-gray-700 min-w-30">
                            {{ __('Remember me') }}
                        </label>
                    </div>
                    <button type="submit" class="btn-primary btn-small justify-center">
                        {{ __('Sign in') }}
                    </button>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        {{ __("Don't have an account?") }}
                        <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-500">
                            {{ __('Register here') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection