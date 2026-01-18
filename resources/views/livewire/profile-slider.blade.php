<div class="profile-slider-container w-full" wire:ignore>
    @if($title)
    <div class="mb-6">
        <h2 class="text-2xl md:text-3xl font-bold text-secondary">{{ $title }}</h2>
    </div>
    @endif

    @if($this->profiles->count() > 0)
    <div class="relative">
        <!-- Custom Navigation buttons -->
        <div class="swiper-button-next-{{ $sliderId }} absolute top-38 -right-5 transform -translate-y-1/2 z-10 cursor-pointer">
            <div class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center hover:shadow-lg transition-all duration-200">
                ⏵
            </div>
        </div>
        <div class="swiper-button-prev-{{ $sliderId }} absolute top-38 -left-5 transform -translate-y-1/2 z-10 cursor-pointer">
            <div class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center hover:shadow-lg transition-all duration-200">
                ⏴
            </div>
        </div>

        <!-- Swiper Container -->
        <div class="swiper {{ $sliderId }} overflow-visible">
            <div class="swiper-wrapper py-4 px-1">
                @foreach($this->profiles as $profile)
                <div class="swiper-slide h-auto">
                    <x-profile-card :profile="$profile" />
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <p class="text-gray-500">{{ __('front.profiles.list.nofound') }}</p>
    </div>
    @endif
</div>

@push('scripts')
<script>
    (function() {
        const sliderId = '{{ $sliderId }}';
        
        function initProfileSlider() {
            // Check if Swiper is available
            if (typeof Swiper === 'undefined') {
                console.error('Swiper is not loaded.');
                return;
            }

            const swiperElement = document.querySelector('.' + sliderId);
            if (!swiperElement) return;

            // Destroy existing instance if any
            if (swiperElement.swiper) {
                swiperElement.swiper.destroy(true, true);
            }

            // Initialize Swiper
            new Swiper('.' + sliderId, {
                slidesPerView: 1,
                spaceBetween: 16,
                
                // Responsive breakpoints
                breakpoints: {
                    480: {
                        slidesPerView: 2,
                        spaceBetween: 16
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 16
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 20
                    },
                    1280: {
                        slidesPerView: 5,
                        spaceBetween: 20
                    }
                },

                navigation: {
                    nextEl: '.swiper-button-next-' + sliderId,
                    prevEl: '.swiper-button-prev-' + sliderId,
                },

                preloadImages: true,
            });

            // Initialize inner swipers for profile cards with multiple images
            swiperElement.querySelectorAll('[class*="profile-swiper-"]').forEach(function(innerSwiperEl) {
                const profileId = innerSwiperEl.className.match(/profile-swiper-(\d+)/)?.[1];
                if (!profileId) return;

                // Destroy existing instance if any
                if (innerSwiperEl.swiper) {
                    innerSwiperEl.swiper.destroy(true, true);
                }

                // Initialize new Swiper instance for profile images
                new Swiper(innerSwiperEl, {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination-' + profileId,
                        clickable: true,
                        dynamicBullets: true,
                    },
                    preloadImages: true,
                });
            });
        }

        // Initialize on DOMContentLoaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initProfileSlider);
        } else {
            initProfileSlider();
        }

        // Re-initialize when Livewire navigates
        document.addEventListener('livewire:navigated', function() {
            setTimeout(initProfileSlider, 100);
        });

        // For Livewire v3 - when content is updated via AJAX
        if (typeof Livewire !== 'undefined') {
            Livewire.hook('morph.updated', () => {
                setTimeout(initProfileSlider, 100);
            });
        }
    })();
</script>
@endpush
