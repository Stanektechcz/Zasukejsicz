<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title', __('front.title'))</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-poppins antialiased text-text-default relative">
    <div id="app">
        <!-- Navigation -->
        <x-navbar /> 

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <x-footer />

        <!-- Auth Modals -->
        @guest
            <livewire:login-modal />
            <livewire:register-modal />
            <livewire:reset-modal />
        @endguest
    </div>

    <!-- Additional Scripts -->
    @stack('scripts')

    @livewireScripts

    <!-- Auth Modal Scripts -->
    @guest
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle escape key to close modals
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    Livewire.dispatch('hide-login-modal');
                    Livewire.dispatch('hide-register-modal');
                    Livewire.dispatch('hide-reset-modal');
                }
            });
        });
    </script>
    @endguest
</body>
</html>
