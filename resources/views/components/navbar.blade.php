<nav class="fixed top-0 left-0 right-0 z-50 bg-transparent rounded-b-3xl transition-all duration-300 py-4" id="navbar" x-data>
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-12 ">
            <!-- Left Side: Logo + Navigation Links -->
            <div class="flex items-center space-x-12">
                <!-- Logo -->
                <a href="{{ route('profiles.index') }}" class="text-xl font-bold text-text-default hover:text-primary-600 transition-colors" id="nav-logo">
                    <span class="text-xl xl:text-2xl font-extrabold">
                        <span class="text-secondary-500">ZAŠUKEJ</span><span class="text-primary-500">SI</span><span class="text-dark-gray">.CZ</span>
                    </span>
                </a>

                <!-- Navigation Links - Desktop -->
                <div class="hidden lg:flex items-center space-x-5 xl:space-x-6">
                    <a href="{{ route('profiles.index') }}" class="nav-link" id="nav-link-1">
                        {{ __('Úvod') }}
                    </a>
                    <a href="#" class="nav-link" id="nav-link-2">
                        {{ __('VIP a Premium') }}
                    </a>
                    <a href="#" class="nav-link" id="nav-link-3">
                        {{ __('FAQ') }}
                    </a>
                    <a href="#" class="nav-link" id="nav-link-3">
                        {{ __('Etika') }}
                    </a>
                    <a href="#" class="nav-link" id="nav-link-3">
                        {{ __('Kontakt') }}
                    </a>
                </div>
            </div>

            <!-- Right Side: Register, Login, Language Switcher -->
            <div class="flex items-center space-x-2">
                @auth
                    <!-- Icon Buttons -->
                    <div class="flex items-center space-x-2">
                        <!-- Notifications Button -->
                        <button class="btn nav-button bg-gray-50 !py-4 !border-1 !text-primary !border-primary" title="{{ __('Notifications') }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button>
                        
                        <!-- Mail Button -->
                        <button class="btn nav-button bg-gray-50 !py-4 !border-1 !text-primary !border-primary" title="{{ __('Mail') }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Account Dropdown (Profile Button) -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="btn nav-button bg-gray-50 !py-4 !border-1 !text-primary !border-primary" title="{{ __('Profile') }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.outside="open = false" x-transition 
                             class="absolute right-0 mt-2 w-48 bg-gray-50 rounded-lg shadow-lg border-2 border-gray-200 z-50">
                            <div>
                                <a href="{{ route('account.dashboard') }}" class="block px-4 py-4 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ __('My account') }}
                                </a>
                                @can('access-filament-admin')
                                    <div class="border-t border-gray-200"></div>
                                    <a href="/admin" target="_blank" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Admin Panel') }}
                                    </a>
                                @endcan
                                <div class="border-t border-gray-200"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Register Button -->
                    <a href="{{ route('register') }}" class="btn-primary">
                        {{ __('Register Now') }}
                    </a>

                    <!-- Login Link -->
                    <div class="hidden lg:inline">
                         <a href="{{ route('login') }}" class="btn-light" id="nav-login">
                             {{ __('Login') }}
                         </a>
                    </div>
                @endauth

                <!-- Language Switcher -->
                <div class="language-dropdown hidden lg:inline" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="language-dropdown-toggle" id="nav-language">
                        @if(app()->getLocale() === 'cs')
                            <img src="{{ asset('flags/cs.png') }}" alt="Czech">
                        @else
                            <img src="{{ asset('flags/en.png') }}" alt="English">
                        @endif
                    </button>
                    
                    <div class="language-dropdown-menu">
                        <a href="{{ url()->current() }}?locale=en" 
                           class="language-dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                           @click="open = false"
                           title="English">
                            <img src="{{ asset('flags/en.png') }}" alt="English">
                        </a>
                        <a href="{{ url()->current() }}?locale=cs" 
                           class="language-dropdown-item {{ app()->getLocale() === 'cs' ? 'active' : '' }}"
                           @click="open = false"
                           title="Čeština">
                            <img src="{{ asset('flags/cs.png') }}" alt="Czech">
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button type="button" class="text-text-default hover:text-primary-600 focus:outline-none focus:text-primary-600" id="mobile-menu-button">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="lg:hidden hidden" id="mobile-menu">
            <div class="flex flex-wrap p-4 py-5 pt-6 space-y-2 bg-gray-100 rounded-2xl">
                <a href="{{ route('profiles.index') }}" class="nav-link-mobile group">
                    {{ __('Úvod') }}
                    <span class="underline"></span>
                </a>
                <a href="#" class="nav-link-mobile group">
                    {{ __('VIP a Premium') }}
                    <span class="underline"></span>
                </a>
                <a href="#" class="nav-link-mobile group">
                    {{ __('FAQ') }}
                    <span class="underline"></span>
                </a>
                <a href="#" class="nav-link-mobile group">
                    {{ __('Etika') }}
                    <span class="underline"></span>
                </a>
                <a href="#" class="nav-link-mobile group">
                    {{ __('Kontakt') }}
                    <span class="underline"></span>
                </a>
                @auth
                    <a href="{{ route('account.dashboard') }}" class="nav-link-mobile group">
                        {{ __('Account Dashboard') }}
                        <span class="underline"></span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="nav-link-mobile group text-left w-full">
                            {{ __('Logout') }}
                            <span class="underline"></span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link-mobile group">
                        {{ __('Login') }}
                        <span class="underline"></span>
                    </a>
                    <a href="{{ route('register') }}" class="nav-link-mobile group">
                        {{ __('Register') }}
                        <span class="underline"></span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>



<script>
    // Navbar scroll behavior - only changes background
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');

        if (window.scrollY > 50) {
            // Scrolled - white background
            navbar.classList.remove('bg-transparent');
            navbar.classList.add('bg-gray-100');
        } else {
            // Top - transparent background
            navbar.classList.add('bg-transparent');
            navbar.classList.remove('bg-gray-100');
        }
    });

    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Language dropdown functionality (fallback for browsers without Alpine.js)
        const languageDropdowns = document.querySelectorAll('.language-dropdown');
        languageDropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.language-dropdown-toggle');
            const menu = dropdown.querySelector('.language-dropdown-menu');
            
            if (toggle && menu) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    dropdown.classList.toggle('open');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('open');
                    }
                });
            }
        });
    });
</script>