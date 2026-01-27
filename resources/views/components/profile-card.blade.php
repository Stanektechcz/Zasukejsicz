@props(['profile'])

@php
    $shouldBlur = $profile->isVip() && (!auth()->check() || !auth()->user()->hasVipAccess());
@endphp

<div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 cursor-pointer group relative z-10">
    <!-- Profile Image -->
    <div class="relative overflow-hidden">

        <!-- Verified Badge -->
        @if($profile->isVerified()) 
        <div class="absolute top-3 left-3 flex flex-col items-start gap-1 z-20">
            <div class="bg-green-100 text-green-500 p-1 px-0.5 rounded-xl flex flex-wrap justify-center">
                <x-icons name="camera" class="w-5 h-5" />
                <p class="text-xs font-bold w-full text-center">
                    OVĚŘENO
                </p>
            </div>
        </div>
        @endif

        @if($shouldBlur)
        <div class="absolute inset-0 z-30 flex items-center justify-center pointer-events-none">
            <span class="inline-flex items-center justify-center bg-white rounded-full p-5 shadow-lg">
                <x-icons name="lock" strokeWidth="1" class="w-8 h-8 text-primary-500 -translate-y-0.5" />
            </span>
        </div>
        @endif

        <!-- Profile Photo -->
        <div class="aspect-[4/5] bg-gradient-to-br from-primary-100 to-secondary-100 relative overflow-hidden {{ $shouldBlur ? 'blur-md' : '' }}">
            @if($profile->getAllImages()->count() > 0)
            @if($profile->hasMultipleImages())
            <!-- Swiper for multiple images -->
            <div class="swiper profile-swiper-{{ $profile->id }} h-full w-full" style="margin-left: 0 !important;">
                <div class="swiper-wrapper" style="transform: translate3d(0, 0, 0) !important;">
                    @foreach($profile->getAllImages() as $image)
                    <div class="swiper-slide" style="width: 100% !important; flex-shrink: 0;">
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
            @if($profile->isVip())
            <div class="bg-gold-500 text-white px-2 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                <x-icons name="star" class="w-3 h-3" />
                VIP
            </div>
            @endif
        </div>

        <!-- Details Button -->
        <a href="{{ $shouldBlur ? '#' : route('profiles.show', $profile) }}"
            class="w-full py-3 px-5 rounded-lg bg-secondary-600 hover:bg-secondary-700 text-white font-semibold transition-colors duration-200 flex items-center justify-between {{ $shouldBlur ? 'pointer-events-none opacity-50' : '' }}">
            <span class="text-lg">{{ __('front.profiles.list.detail') }}</span>
            <x-icons name="search" class="w-5 h-5 text-white" strokeWidth="3" />
        </a>

        <!-- Rating/Evaluation -->
        <div>
            <div class="flex bg-gray-200 rounded-lg justify-between">
                <div class="flex-1 bg-gray-100 rounded-lg p-3 py-2">
                    <div class="text-sm font-medium text-gray-700">{{ __('front.profiles.list.rating') }}</div>
                </div>
                <div class="flex-1 rounded-r-lg px-2 py-2 flex items-center justify-center gap-1">
                    @if($profile->getTotalRatings() > 0)
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm font-bold text-gray-900">{{ number_format($profile->getAverageRating(), 1) }}</span>
                    @else
                        <span class="text-xs text-gray-500">—</span>
                    @endif
                </div>
            </div>


            <!-- Location -->
            <div class="flex py-2 justify-center items-center gap-x-2 text-sm text-primary-600">
                @if($profile->city)
                <x-icons name="location" class="w-4 h-4 -translate-y-0.5" />
                <h5 class="py-1 text-center">{{ $profile->city }}</h5>
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
