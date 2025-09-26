@extends('layouts.app')

@section('title', __('front.auth.register.title'))

@section('content')
<!-- Add top padding to account for fixed navbar -->
<div class="pt-28 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="p-10 rounded-3xl max-w-2xl w-full space-y-8 border-2 border-gray-200">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-text-default">
                {{ __('front.auth.register.create') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('front.auth.register.join') }}
            </p>
        </div>

        <div class="px-8 pt-2">
            <form class="space-y-5" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name">{{ __('front.auth.register.fullname') }}</label>
                    <input id="name" name="name" type="text" autocomplete="name" required
                        class="input-control mt-1 @error('name') border-red-500 @enderror"
                        placeholder="{{ __('front.auth.register.entername') }}"
                        value="{{ old('name') }}">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email">{{ __('front.auth.register.email') }}</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="input-control mt-1 @error('email') border-red-500 @enderror"
                        placeholder="{{ __('front.auth.register.enteremail') }}"
                        value="{{ old('email') }}">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone">{{ __('front.auth.register.phone') }} ({{ __('front.auth.register.optional') }})</label>
                    <input id="phone" name="phone" type="tel" autocomplete="tel"
                        class="input-control mt-1 @error('phone') border-red-500 @enderror"
                        placeholder="{{ __('front.auth.register.enterphone') }}"
                        value="{{ old('phone') }}">
                    @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password">{{ __('front.auth.register.password') }}</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="input-control mt-1 @error('password') border-red-500 @enderror"
                        placeholder="{{ __('front.auth.register.enterpassword') }}">
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation">{{ __('front.auth.register.confirm') }}</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                        class="input-control mt-1 @error('password_confirmation') border-red-500 @enderror"
                        placeholder="{{ __('front.auth.register.confirmpassword') }}">
                    @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms and Submit Button -->
                <div class="w-full flex items-center justify-between space-x-6">
                    <div class="text-xs text-gray-600 max-w-xs">
                        {{ __('front.auth.register.agree') }}
                        <br/>
                        <a href="#" class="text-primary-600 hover:text-primary-500">{{ __('front.auth.register.terms') }}</a>
                        {{ __('front.auth.register.and') }}
                        <a href="#" class="text-primary-600 hover:text-primary-500">{{ __('front.auth.register.privacy') }}</a>.
                    </div>
                    <button type="submit" class="btn-primary btn-small justify-center">
                        {{ __('front.auth.register.createbutton') }}
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center pt-6">
                    <p class="text-sm text-gray-600">
                        {{ __('front.auth.register.haveaccount') }}
                        <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                            {{ __('front.auth.register.signinhere') }}
                        </a>
                    </p>
                </div>


            </form>
        </div>
    </div>
</div>
@endsection