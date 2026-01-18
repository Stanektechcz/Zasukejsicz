<div>
    <div class="mt-2 px-6 md:px-8 lg:px-12 py-9 flex items-center gap-4">
        <x-icons name="search" class="w-7 h-7 text-primary-600" />
        <h1 class="text-4xl font-bold text-secondary">{{ __('front.profiles.list.topresults') }}</h1>
    </div>

    <!-- Quick Filters -->
    <div class="mb-8 px-6 md:px-8 lg:px-12">
        <!-- Age Group Filters -->
        <div class="flex flex-wrap gap-3 mb-4">
            <!-- All Girls Filter -->
            <button wire:click="toggleAgeGroup('')"
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border-2 {{ $ageGroup === '' ? 'border-primary text-gray-700 bg-white' : 'border-gray-100 text-gray-700 bg-white' }} hover:border-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
                wire:target="toggleAgeGroup">
                <span wire:target="toggleAgeGroup">
                    <x-icons name="users" class="w-4 h-4 mr-2 {{ $ageGroup === '' ? 'text-primary' : 'text-gray-500' }}" />
                </span>
                All Girls
            </button>

            @foreach(['18-25' => '18-25 yo', '26-30' => '26-30 yo', '31-35' => '31-35 yo', '36-40' => '36-40 yo', '40-50' => '40-50 yo', '50+' => '50 yo +'] as $value => $label)
            <button wire:click="toggleAgeGroup('{{ $value }}')"
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border-2 {{ $ageGroup === $value ? 'border-primary text-gray-700 bg-white' : 'border-gray-100 text-gray-700 bg-white' }} hover:border-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
                wire:target="toggleAgeGroup">
                <span wire:target="toggleAgeGroup">{{ $label }}</span>
            </button>
            @endforeach
        </div>

        <!-- Feature Filters -->
        <div class="flex flex-wrap gap-3">
            <!-- Recommendation Filter -->
            <button wire:click="toggleRecommendation"
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border-2 {{ $sortRecommendation !== '' ? 'border-primary text-gray-700 bg-white' : 'border-gray-100 text-gray-700 bg-white' }} hover:border-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
                wire:target="toggleRecommendation">
                @if($sortRecommendation === 'desc')
                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                @elseif($sortRecommendation === 'asc')
                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @else
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>
                @endif
                Recommendation
            </button>

            <!-- Verified Photo Filter -->
            <button wire:click="toggleVerifiedPhoto"
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border-2 {{ $hasVerifiedPhoto ? 'border-primary text-gray-700 bg-white' : 'border-gray-100 text-gray-700 bg-white' }} hover:border-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
                wire:target="toggleVerifiedPhoto">
                <svg wire:target="toggleVerifiedPhoto" class="w-4 h-4 mr-2 {{ $hasVerifiedPhoto ? 'text-primary' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Verified photo
            </button>

            <!-- Video Filter -->
            <button wire:click="toggleVideo"
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border-2 {{ $hasVideo ? 'border-primary text-gray-700 bg-white' : 'border-gray-100 text-gray-700 bg-white' }} hover:border-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
                wire:target="toggleVideo">
                <svg wire:target="toggleVideo" class="w-4 h-4 mr-2 {{ $hasVideo ? 'text-primary' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                Video
            </button>

            <!-- Porn Actress Filter -->
            <button wire:click="togglePornActress"
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border-2 {{ $isPornActress ? 'border-primary text-gray-700 bg-white' : 'border-gray-100 text-gray-700 bg-white' }} hover:border-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
                wire:target="togglePornActress">
                <svg wire:target="togglePornActress" class="w-4 h-4 mr-2 {{ $isPornActress ? 'text-primary' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
                Porno actress
            </button>

            <!-- New Filter -->
            <button wire:click="toggleNew"
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border-2 {{ $sortNew !== '' ? 'border-primary text-gray-700 bg-white' : 'border-gray-100 text-gray-700 bg-white' }} hover:border-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
                wire:target="toggleNew">
                @if($sortNew === 'desc')
                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                @elseif($sortNew === 'asc')
                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @else
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                @endif
                New
            </button>

            <!-- Rating Filter -->
            <button wire:click="toggleRating"
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border-2 {{ $hasRating ? 'border-primary text-gray-700 bg-white' : 'border-gray-100 text-gray-700 bg-white' }} hover:border-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
                wire:target="toggleRating">
                <svg wire:target="toggleRating" class="w-4 h-4 mr-2 {{ $hasRating ? 'text-primary' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                </svg>
                Rating
            </button>

            <!-- Clear All Filters Button -->
            @if($this->activeFiltersCount() > 0)
            <button wire:click="resetFilters"
                wire:loading.attr="disabled"
                wire:target="resetFilters"
                class="inline-flex items-center justify-center w-10 h-10 rounded-full text-sm font-medium transition-all duration-200 border-2 border-red-200 text-red-600 bg-white hover:border-red-300 hover:bg-red-50 disabled:opacity-50 disabled:cursor-not-allowed"
                title="{{ __('front.profiles.list.clear_all_filters') }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            @endif
        </div>

        <!-- Active Filters Count -->
        @if($this->activeFiltersCount() > 0)
        <div class="mt-4">
            <span class="text-sm text-gray-600">
                {{ $this->activeFiltersCount() }} filter(s) active
            </span>
        </div>
        @endif
    </div>

    @if($this->profiles() && $this->profiles()->count() > 0)
    <!-- Profiles Grid -->
    <div class="space-y-6 relative px-6 md:px-8 lg:px-12">
        <!-- Loading Overlay -->
        <div wire:loading wire:target="toggleAgeGroup,toggleRecommendation,toggleVerifiedPhoto,toggleVideo,togglePornActress,toggleNew,toggleRating,resetFilters,updateFilters"
            class="absolute inset-0 bg-white/80 z-10 flex items-center justify-center pt-12">
            <div class="flex flex-col items-center">
                <svg class="animate-spin h-12 w-12 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($this->profiles() as $profile)
            
            {{-- Insert Advert Hero after second row (10 items on xl screens) --}}
            @if($loop->iteration === 6)
                <div class="col-span-full my-4">
                    <div class="bg-green-100 rounded-2xl py-3 px-6 mx-auto">
                        <div class="flex items-center justify-center gap-3 text-center">
                            <x-icons name="eco" class="w-5 h-5 text-green-600 flex-shrink-0" />
                            <p class="text-sm font-medium text-green-600">
                                <span class="font-semibold text-green-700">Our project is eco-friendly</span> – Thanks to the girl verification system, you won't travel anywhere unnecessarily.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if($loop->iteration === 11)
                <div class="col-span-full hidden lg:block -my-20 -mx-6 md:-mx-8 lg:-mx-12 relative z-0">
                    <x-advert-hero />
                </div>
            @endif
            
            <x-profile-card :profile="$profile" />
            @endforeach
        </div>

        <!-- Load More Button -->
        @if($this->profiles()->hasMorePages())
        <div class="text-center mt-8">
            <button wire:click="loadMore"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed shadow hover:shadow-md px-8 py-3 text-base bg-secondary-600 text-white hover:bg-secondary-700 focus:ring-secondary-500">
                <svg wire:loading wire:target="loadMore" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="loadMore">{{ __('front.profiles.list.loadmore') }}</span>
                <span wire:loading wire:target="loadMore">{{ __('front.profiles.list.loadingmore') }}</span>
            </button>
        </div>
        @endif

        <!-- Results Count -->
        <div class="text-center text-sm text-gray-600 mt-4">
            <span>{{ __('front.profiles.list.showing') }} {{ $this->profiles()->count() }} {{ __('front.profiles.list.of') }} {{ $this->profiles()->total() }} {{ __('front.profiles.list.profiles') }}</span>
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

        <button wire:click="resetFilters" class="btn btn-primary">
            {{ __('front.profiles.list.showall') }}
        </button>
    </div>
    @endif


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