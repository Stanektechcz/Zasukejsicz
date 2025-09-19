<nav class="fixed top-0 left-0 right-0 z-50 bg-transparent transition-all duration-300 py-4" id="navbar">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-12">
            <!-- Left Side: Logo + Navigation Links -->
            <div class="flex items-center space-x-12">
                <!-- Logo -->
                <a href="{{ route('profiles.index') }}" class="text-xl font-bold text-text-default hover:text-primary-600 transition-colors" id="nav-logo">
                    <span class="text-xl xl:text-2xl font-extrabold">
                        <span class="text-secondary-500">ZAŠUKEJ</span><span class="text-primary-500">SI</span><span class="text-dark-gray">.CZ</span>
                    </span>
                </a>

                <!-- Navigation Links - Desktop -->
                <div class="hidden lg:flex items-center space-x-5 xl:space-x-8">
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
            <div class="flex items-center space-x-4">
                <!-- Register Button -->
                <a href="#" class="btn btn-primary">
                    {{ __('Register Now') }}
                </a>

                <!-- Login Link -->
                <div class="hidden lg:inline">
                     <a href="#" class="btn btn-light " id="nav-login">
                         {{ __('Login') }}
                     </a>
                </div>

                <!-- Language Switcher -->
                <div class="relative hidden lg:inline">
                    <select class="icon-select"
                        id="nav-language"
                        onchange="window.location.href = this.value">
                        <option value="{{ url()->current() }}?locale=en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>
                            🇺🇸
                        </option>
                        <option value="{{ url()->current() }}?locale=cs" {{ app()->getLocale() === 'cs' ? 'selected' : '' }}>
                            🇨🇿
                        </option>
                    </select>
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
            <div class="flex flex-wrap p-4 py-5 pt-6 space-y-2 bg-white rounded-2xl">
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
                <a href="#" class="nav-link-mobile group">
                    {{ __('Login') }}
                    <span class="underline"></span>
                </a>
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
            navbar.classList.add('bg-white', 'shadow-sm');
        } else {
            // Top - transparent background
            navbar.classList.add('bg-transparent');
            navbar.classList.remove('bg-white', 'shadow-sm');
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
    });
</script>