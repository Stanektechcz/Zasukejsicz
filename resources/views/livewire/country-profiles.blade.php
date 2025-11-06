<div>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Left Panel - Countries List -->
        <div class="lg:col-span-1">
            <div class="p-6 sticky top-24">
                <div class="space-y-2">

                    <!-- Individual Countries -->
                    @foreach($countries as $country)
                    <div class="space-y-1">
                        <!-- Country Button -->
                        <button wire:click="toggleCountryExpansion({{ $country->id }})"
                            class="w-full flex items-center gap-3 p-3 text-left transition-all duration-200 {{ $selectedCountryId == $country->id && !$selectedCity ? 'bg-primary-50 text-primary-700' : '' }}">
                            <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0">
                                @if($country->hasFlagImage())
                                    <img src="{{ $country->getFlagImageThumbUrl() }}" 
                                         alt="{{ $country->getTranslation('country_name', app()->getLocale()) }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-sm">{{ $country->getTranslation('country_name', app()->getLocale()) }}</div>
                            </div>
                            <div class="text-sm text-gray-500 ml-auto">
                                {{ $country->profiles_count }}
                            </div>
                        </button>

                        <!-- Cities Dropdown -->
                        @if($country->cities && $country->cities->count() > 0 && in_array($country->id, $expandedCountries))
                        <div class="flex justify-end" >
                            <div class="w-10/12 rounded-2xl space-y-0.5">
                                @foreach($country->cities as $city)
                                <button wire:click="selectCity({{ $country->id }}, '{{ $city->city }}')"
                                    class="w-full bg-gray-100 hover:bg-primary hover:text-white flex items-center gap-3 p-1 px-3 text-left text-sm {{ $selectedCountryId == $country->id && $selectedCity == $city->city ? 'bg-primary text-white' : '' }} {{ $loop->first ? 'rounded-t-lg' : '' }} {{ $loop->last ? 'rounded-b-lg' : '' }}">
                                    <div class="flex-1">
                                        <div class="font-medium text-sm">{{ $city->city }}</div>
                                    </div>
                                    <div class="text-xs hover:bg-primary hover:text-white ml-auto">
                                        {{ $city->profiles_count }}
                                    </div>
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Panel - Profiles -->
        <div class="lg:col-span-3">
            <!-- Header -->
            <div class="mb-6">
                @if($selectedCountry && $selectedCity)
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ __('front.countries.profiles_from') }} {{ $selectedCity }}, {{ $selectedCountry->getTranslation('country_name', app()->getLocale()) }}
                    </h2>
                    <p class="text-gray-600 mt-1">
                        {{ $profiles->total() }} {{ __('front.countries.profiles_found') }}
                    </p>
                @elseif($selectedCountry)
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ __('front.countries.profiles_from') }} {{ $selectedCountry->getTranslation('country_name', app()->getLocale()) }}
                    </h2>
                    <p class="text-gray-600 mt-1">
                        {{ $profiles->total() }} {{ __('front.countries.profiles_found') }}
                    </p>
                @else
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ __('front.countries.all_profiles') }}
                    </h2>
                    <p class="text-gray-600 mt-1">
                        {{ $profiles->total() }} {{ __('front.countries.profiles_found') }}
                    </p>
                @endif
            </div>

            <!-- Profiles Grid -->
            @if($profiles && $profiles->count() > 0)
                <div class="space-y-6 relative">
                    <!-- Loading Overlay -->
                    <div wire:loading wire:target="selectCountry" 
                        class="absolute inset-0 bg-white/80 z-10 flex items-center justify-center">
                        <div class="flex flex-col items-center">
                            <svg class="animate-spin h-12 w-12 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($profiles as $profile)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 cursor-pointer group">
                            <!-- Profile Image -->
                            <div class="relative">
                                <!-- Verified Badge -->
                                @if($profile->isVerified())
                                <div class="absolute top-3 left-3 flex flex-col items-start gap-1">
                                    <div class="bg-green-100 text-green-500 p-1 px-0.5 rounded-xl flex flex-wrap justify-center">
                                        <x-icons name="camera" class="w-5 h-5" />
                                        <p class="text-xs font-bold w-full text-center">
                                            OVĚŘENO
                                        </p>
                                    </div>
                                </div>
                                @endif

                                <!-- Profile Photo -->
                                <div class="aspect-[4/5] bg-gradient-to-br from-primary-100 to-secondary-100 relative overflow-hidden">
                                    @if($profile->getAllImages()->count() > 0)
                                    @if($profile->hasMultipleImages())
                                    <!-- Swiper for multiple images -->
                                    <div class="swiper profile-swiper-{{ $profile->id }} w-full h-full">
                                        <div class="swiper-wrapper">
                                            @foreach($profile->getAllImages() as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ $image->getUrl() }}" alt="{{ $profile->display_name }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            @endforeach
                                        </div>
                                        <!-- Pagination -->
                                        <div class="swiper-pagination swiper-pagination-{{ $profile->id }}"></div>
                                    </div>
                                    @else
                                    <!-- Single image -->
                                    <img src="{{ $profile->getFirstImageUrl() }}" alt="{{ $profile->display_name }}"
                                        class="w-full h-full object-cover">
                                    @endif
                                    @else
                                    <!-- No image placeholder -->
                                    <div class="flex items-center justify-center w-full h-full">
                                        <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Profile Info -->
                            <div class="p-4 space-y-3">
                                <!-- Name and VIP Badge -->
                                <div class="flex items-center justify-between py-3">
                                    <h4 class="text-gray-700 flex-grow-0 truncate max-w-[80%]">{{ $profile->display_name }}</h4>
                                    @if(!$profile->is_vip)
                                    <div class="bg-gold-500 text-white px-2 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                        <x-icons name="star" class="w-3 h-3" />
                                        VIP
                                    </div>
                                    @endif
                                </div>

                                <!-- Details Button -->
                                <a href="{{ route('profiles.show', $profile) }}"
                                    class="w-full py-3 px-5 rounded-lg bg-secondary-600 hover:bg-secondary-700 text-white font-semibold transition-colors duration-200 flex items-center justify-between">
                                    <span class="text-lg">{{ __('front.profiles.list.detail') }}</span>
                                    <x-icons name="search" class="w-5 h-5 text-white" strokeWidth="3" />
                                </a>

                                <!-- Rating/Evaluation -->
                                <div>
                                    <div class="flex bg-gray-200 rounded-lg justify-between">
                                        <div class="flex-1 bg-gray-100 rounded-lg p-3 py-2">
                                            <div class="text-sm font-medium text-gray-700">{{ __('front.profiles.list.rating') }}</div>
                                        </div>
                                        <div class="flex-1 rounded-r-lg px-2 py-2 flex items-center justify-center">
                                            <x-icons name="lock" class="w-4 h-4 text-primary" />
                                        </div>
                                    </div>

                                    <!-- Location -->
                                    <div class="flex py-2 justify-center items-center gap-x-2 text-sm text-primary-600">
                                        @if($profile->city)
                                        <x-icons name="location" class="w-4 h-4 -translate-y-0.5" />
                                        <h5 class="py-1 text-center">{{ $profile->city }}</h5>
                                        @endif
                                        @if($profile->country)
                                        <span class="text-gray-400">•</span>
                                        <span class="text-xs">{{ $profile->country->getTranslation('country_name', app()->getLocale()) }}</span>
                                        @endif
                                    </div>

                                    <div class="flex justify-between gap-x-3">
                                        <div class="flex-1 bg-gray-100 rounded-lg p-3 text-center">
                                            <div class="text-xs ">168 cm</div>
                                        </div>
                                        <div class="flex-1 bg-gray-100 rounded-lg p-3 text-center">
                                            <div class="text-xs ">{{ $profile->age }} {{ __('front.profiles.list.years') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Load More Button -->
                    @if($profiles->hasMorePages())
                    <div class="text-center mt-8">
                        <button wire:click="loadMore"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed shadow hover:shadow-md px-8 py-3 text-base bg-secondary-600 text-white hover:bg-secondary-700 focus:ring-secondary-500">
                            <span wire:loading.remove wire:target="loadMore">{{ __('front.profiles.list.loadmore') }}</span>
                            <span wire:loading wire:target="loadMore" class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 818-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('front.profiles.list.loadingmore') }}
                            </span>
                        </button>
                    </div>
                    @endif

                    <!-- Results Count -->
                    <div class="text-center text-sm text-gray-600 mt-4">
                        <span>{{ __('front.profiles.list.showing') }} {{ $profiles->count() }} {{ __('front.profiles.list.of') }} {{ $profiles->total() }} {{ __('front.profiles.list.profiles') }}</span>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16" wire:loading.remove>
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="text-gray-500 mb-2">{{ __('front.profiles.list.nofound') }}</h3>
                    <p class="text-gray-600 mb-6">{{ __('front.profiles.list.tryadjusting') }}</p>

                    <button wire:click="selectCountry()" class="btn btn-primary">
                        {{ __('front.profiles.list.showall') }}
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if Swiper is available
        if (typeof Swiper === 'undefined') {
            console.error('Swiper is not loaded. Make sure to build assets with npm run build');
            return;
        }

        initializeSwipers();
    });

    // Initialize Swiper instances
    function initializeSwipers() {
        // Find all profile swipers and initialize them
        document.querySelectorAll('[class*="profile-swiper-"]').forEach(function(swiperEl) {
            const profileId = swiperEl.className.match(/profile-swiper-(\d+)/)[1];

            // Destroy existing swiper instance if any
            if (swiperEl.swiper) {
                swiperEl.swiper.destroy(true, true);
            }

            // Initialize new Swiper instance
            new Swiper(swiperEl, {
                loop: true,
                pagination: {
                    el: `.swiper-pagination-${profileId}`,
                    clickable: true,
                    dynamicBullets: true,
                },
                preloadImages: true,
            });
        });
    }

    // Re-initialize Swiper when Livewire updates content
    document.addEventListener('livewire:navigated', function() {
        setTimeout(initializeSwipers, 100);
    });

    // For Livewire v3 - when content is updated via AJAX
    if (typeof Livewire !== 'undefined') {
        Livewire.hook('morph.updated', () => {
            setTimeout(initializeSwipers, 100);
        });

        // Also listen for specific Livewire events
        Livewire.on('profiles-updated', () => {
            setTimeout(initializeSwipers, 100);
        });
    }
</script>
@endpush
