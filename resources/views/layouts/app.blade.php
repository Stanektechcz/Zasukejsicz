<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title', 'Find Your Perfect Massage Therapist')</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-poppins antialiased bg-light-bg text-text-default">
    <div id="app">
        <!-- Navigation -->
        <x-navbar /> 

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white mt-16">
            <x-section class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div class="md:col-span-2">
                        <x-heading size="h3" class="text-white mb-4">{{ config('app.name') }}</x-heading>
                        <p class="text-gray-300 mb-4 max-w-md">
                            {{ __('We are community of people who like to fuck.') }}
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <x-heading size="h4" class="text-white mb-4">{{ __('Quick Links') }}</x-heading>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('profiles.index') }}" class="text-gray-300 hover:text-white transition-colors">{{ __('Browse Therapists') }}</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">{{ __('How It Works') }}</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">{{ __('Safety Guidelines') }}</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">{{ __('Contact Us') }}</a></li>
                        </ul>
                    </div>

                    <!-- For Therapists -->
                    <div>
                        <x-heading size="h4" class="text-white mb-4">{{ __('For Therapists') }}</x-heading>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">{{ __('Join Platform') }}</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">{{ __('Pricing') }}</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">{{ __('Support') }}</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                    </p>
                    <div class="mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors mr-6">{{ __('Privacy Policy') }}</a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">{{ __('Terms of Service') }}</a>
                    </div>
                </div>
            </x-section>
        </footer>
    </div>
</body>
</html>
