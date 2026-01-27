<nav class="fixed top-0 left-0 right-0 z-50 bg-transparent rounded-b-3xl transition-all duration-300 py-4 bg-white " id="navbar" x-data>
    <div class="container mx-auto px-4 ">
        <div class="flex justify-between items-center h-12 ">
            <!-- Left Side: Logo + Navigation Links -->
            <div class="flex items-center space-x-3 md:space-x-12">
                <!-- Logo -->
                <a href="{{ route('profiles.index') }}" class="text-xl font-bold text-text-default hover:text-primary-600 transition-colors" id="nav-logo">
                    <span class="text-xl xl:text-2xl font-extrabold">
                        <span class="text-secondary-500">ZAŠUKEJ</span><span class="text-primary-500">SI</span><span class="text-dark-gray">.CZ</span>
                    </span>
                </a>

                <!-- Navigation Links - Desktop -->
                <div class="hidden lg:flex items-center space-x-5 xl:space-x-6">
                    @foreach($navPages ?? [] as $page)
                        <a href="{{ url('/' . $page->slug) }}" class="nav-link" id="nav-link-{{ $page->id }}">
                            {{ $page->title }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Right Side: Register, Login, Language Switcher -->
            <div class="flex items-center space-x-1 md:space-x-2">
                @auth
                    <!-- Icon Buttons - Desktop Only -->
                    <div class="hidden lg:flex items-center space-x-2">
                        <!-- Notifications Button -->
                        @livewire('notifications-dropdown')
                        
                        <!-- Mail Button -->
                        <a href="{{ route('messages.index') }}" class="btn nav-button bg-gray-50 !px-2 !py-2 md:!px-4 md:!py-4 !border-1 !text-primary !border-primary relative rounded md:rounded-lg" title="{{ __('front.nav.mail') }}">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            @php
                                $unreadMessages = Auth::user()->receivedMessages()->unread()->count();
                            @endphp
                            @if($unreadMessages > 0)
                                <span class="absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full h-4 w-4 md:h-5 md:w-5 flex items-center justify-center text-[10px] md:text-xs">
                                    {{ $unreadMessages > 9 ? '9+' : $unreadMessages }}
                                </span>
                            @endif
                        </a>
                    </div>

                    <!-- Account Dropdown (Profile Button) -->
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen" 
                            class="btn nav-button !px-2 !py-2 md:!px-4 md:!py-4 transition-colors relative z-50"
                            :class="userMenuOpen ? 'translate-y-1 bg-primary !text-white !border-primary !border-t-1 !border-l-1 !border-r-1 !border-b-0 !rounded-b-none !pb-4 md:!pb-6 !mt-0' : 'bg-gray-50 !text-primary !border-primary !border-1 rounded md:rounded-lg'"
                            style="transform-origin: top center;"
                            title="{{ __('front.nav.profile') }}">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>
                        
                        <div x-show="userMenuOpen" @click.outside="userMenuOpen = false" x-transition 
                            class="absolute right-0 lg:-right-15 top-10 md:top-16 w-48 bg-primary rounded-lg shadow-lg z-40 p-4 px-5 border-t-1 border-l-1 border-r-1 border-primary">
                            <div>
                               <a href="{{ route('account.dashboard') }}" class="block p-5 py-3 text-sm text-white hover:bg-secondary-500 rounded-lg transition-colors">
                                  {{ __('front.nav.myaccount') }}
                               </a>
                               @can('access-filament-admin')
                                  <a href="/admin" target="_blank" class="block px-4 py-3 text-sm text-white hover:bg-secondary-500 rounded-lg transition-colors">
                                     {{ __('front.nav.adminpanel') }}
                                  </a>
                               @endcan
                               <div class="border-t border-white/30 my-2"></div>
                               <form method="POST" action="{{ route('logout') }}">
                                  @csrf
                                  <button type="submit" class="block w-full text-left p-5 py-3 text-sm text-white hover:bg-secondary-500 rounded-lg transition-colors">
                                     {{ __('front.nav.logout') }}
                                  </button>
                               </form>
                            </div>
                        </div>
                    </div> 
                @else
                    <!-- Register Button - Desktop Only -->
                    <div class="hidden lg:inline-block">
                        <button @click="$dispatch('show-register-modal')" class="btn-primary">
                            {{ __('front.nav.register') }}
                        </button>
                    </div>
                    <!-- Login Link - Desktop Only -->
                    <div class="hidden lg:inline-block">
                         <button @click="$dispatch('show-login-modal')" class="btn-light" id="nav-login">
                             {{ __('front.nav.login') }}
                         </button>
                    </div>
                @endauth

                <!-- Language Switcher - Desktop Only -->
                <div class="hidden lg:inline">
                    <div class="language-dropdown " x-data="{ languageOpen: false }" @click.outside="languageOpen = false">
                        <button @click="languageOpen = !languageOpen" class="language-dropdown-toggle" id="nav-language">
                            @if(app()->getLocale() === 'cs')
                                <img src="{{ asset('flags/cs.png') }}" alt="Czech">
                            @else
                                <img src="{{ asset('flags/en.png') }}" alt="English">
                            @endif
                        </button>
                        
                        <div class="language-dropdown-menu">
                            <a href="{{ url()->current() }}?locale=en" 
                               class="language-dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                               @click="languageOpen = false"
                               title="English">
                                <img src="{{ asset('flags/en.png') }}" alt="English">
                            </a>
                            <a href="{{ url()->current() }}?locale=cs" 
                               class="language-dropdown-item {{ app()->getLocale() === 'cs' ? 'active' : '' }}"
                               @click="languageOpen = false"
                               title="Čeština">
                                <img src="{{ asset('flags/cs.png') }}" alt="Czech">
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Mobile menu button -->
                <div class="lg:hidden" x-data="{ mobileMenuOpen: false }" @click.outside="mobileMenuOpen = false">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="flex items-center justify-center text-text-default hover:text-primary-600 focus:outline-none focus:text-primary-600" id="mobile-menu-button">
                        <x-icons name="burger" x-show="!mobileMenuOpen" strokeWidth="2" class="h-2 w-6" block="false"/>
                        <x-icons name="close" x-show="mobileMenuOpen" strokeWidth="2" class="h-6 w-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="lg:hidden hidden" id="mobile-menu">
            <div class="flex flex-wrap p-4 py-5 pt-6 space-y-2 bg-white rounded-2xl">
                
                @auth
                    <!-- Icon Buttons - Mobile Only -->
                    <div class="w-full flex items-center justify-center gap-3 pb-4 border-b border-gray-200 mb-2">
                        <!-- Notifications Button -->
                        @livewire('notifications-dropdown')
                        
                        <!-- Mail Button -->
                        <a href="{{ route('messages.index') }}" class="btn nav-button bg-gray-50 !px-4 !py-4 !border-1 !text-primary !border-primary relative rounded-lg" title="{{ __('front.nav.mail') }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            @php
                                $unreadMessages = Auth::user()->receivedMessages()->unread()->count();
                            @endphp
                            @if($unreadMessages > 0)
                                <span class="absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center text-xs">
                                    {{ $unreadMessages > 9 ? '9+' : $unreadMessages }}
                                </span>
                            @endif
                        </a>
                        
                    </div>
                @endauth
                
                @foreach($navPages ?? [] as $page)
                    <a href="{{ url('/' . $page->slug) }}" class="nav-link-mobile group">
                        {{ $page->title }}
                        <span class="underline"></span>
                    </a>
                @endforeach
                @auth
                    <a href="{{ route('account.dashboard') }}" class="nav-link-mobile group">
                        {{ __('front.nav.accountdashboard') }}
                        <span class="underline"></span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="nav-link-mobile group text-left w-full">
                            {{ __('front.nav.logout') }}
                            <span class="underline"></span>
                        </button>
                    </form>
                @else
                    <!-- Auth Buttons -->
                    <div class="w-full space-y-3 pt-4">
                        <button @click="$dispatch('show-register-modal')" class="w-full btn-primary py-3 text-center">
                            {{ __('front.nav.register') }}
                        </button>
                        <button @click="$dispatch('show-login-modal')" class="w-full btn-light py-3 text-center">
                            {{ __('front.nav.login') }}
                        </button>
                    </div>
                @endauth
                
                <!-- Language Switcher -->
                <div class="w-full pt-4 border-t border-gray-300 mt-4">
                    <div class="flex justify-center gap-4">
                        <a href="{{ url()->current() }}?locale=cs" class="flex items-center gap-2 {{ app()->getLocale() === 'cs' ? 'opacity-100' : 'opacity-50' }}">
                            <img src="{{ asset('flags/cs.png') }}" alt="Czech" class="w-8 h-8 rounded-full">
                            <span class="text-sm">Česky</span>
                        </a>
                        <a href="{{ url()->current() }}?locale=en" class="flex items-center gap-2 {{ app()->getLocale() === 'en' ? 'opacity-100' : 'opacity-50' }}">
                            <img src="{{ asset('flags/en.png') }}" alt="English" class="w-8 h-8 rounded-full">
                            <span class="text-sm">English</span>
                        </a>
                    </div>
                </div>
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