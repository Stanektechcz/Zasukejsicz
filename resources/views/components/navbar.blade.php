<nav class="fixed top-0 left-0 right-0 z-50 bg-transparent rounded-b-3xl transition-all duration-300 py-4 bg-white " id="navbar" x-data>
    <div class="container mx-auto px-4 ">
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
                    @foreach($navPages ?? [] as $page)
                        <a href="{{ url('/' . $page->slug) }}" class="nav-link" id="nav-link-{{ $page->id }}">
                            {{ $page->title }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Right Side: Register, Login, Language Switcher -->
            <div class="flex items-center space-x-2">
                @auth
                    <!-- Icon Buttons -->
                    <div class="flex items-center space-x-2">
                        <!-- Notifications Button -->
                        <div class="relative" x-data="{ notificationsOpen: false }">
                            <button @click="notificationsOpen = !notificationsOpen" class="btn nav-button bg-gray-50 !py-4 !border-1 !text-primary !border-primary relative" title="{{ __('front.nav.notifications') }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @php
                                    $unreadCount = Auth::user()->notifications()->unread()->forUser(Auth::id())->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                    </span>
                                @endif
                            </button>
                            
                            <div x-show="notificationsOpen" @click.outside="notificationsOpen = false" x-transition 
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg z-50 max-h-96 overflow-y-auto">
                                @php
                                    $notifications = Auth::user()->notifications()->forUser(Auth::id())->latest()->limit(10)->get();
                                @endphp
                                
                                @if($notifications->isEmpty())
                                    <div class="p-6 text-center text-gray-500">
                                        {{ __('No notifications') }}
                                    </div>
                                @else
                                    @foreach($notifications as $notification)
                                        <div class="p-4 {{ !$notification->read_at ? 'bg-primary/5' : '' }} hover:bg-gray-50 transition-colors">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1 pr-2">
                                                    <h4 class="font-medium text-gray-900 text-sm">{{ $notification->title }}</h4>
                                                    <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                                    <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                                <form method="POST" action="{{ route('notifications.delete', $notification) }}" class="flex-shrink-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-primary">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        
                        <!-- Mail Button -->
                        <a href="{{ route('messages.index') }}" class="btn nav-button bg-gray-50 !py-4 !border-1 !text-primary !border-primary relative" title="{{ __('front.nav.mail') }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            @php
                                $unreadMessages = Auth::user()->receivedMessages()->unread()->count();
                            @endphp
                            @if($unreadMessages > 0)
                                <span class="absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $unreadMessages > 9 ? '9+' : $unreadMessages }}
                                </span>
                            @endif
                        </a>
                    </div>

                    <!-- Account Dropdown (Profile Button) -->
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen" 
                            class="btn nav-button !py-4 transition-colors"
                            :class="userMenuOpen ? 'bg-primary !text-white !border-primary !border-t-1 !border-l-1 !border-r-1 !border-b-0 !rounded-b-none' : 'bg-gray-50 !text-primary !border-primary !border-1'"
                            title="{{ __('front.nav.profile') }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>
                        
                        <div x-show="userMenuOpen" @click.outside="userMenuOpen = false" x-transition 
                            class="absolute -right-1/2 top-14 w-48 bg-primary rounded-lg shadow-lg z-50 p-4 px-5">
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
        </div>

        <!-- Mobile menu -->
        <div class="lg:hidden hidden" id="mobile-menu">
            <div class="flex flex-wrap p-4 py-5 pt-6 space-y-2 bg-white rounded-2xl">
                
                
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