@extends('layouts.member')

@section('member-content')
<!-- Page Title -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">{{ __('front.account.member.favorites') }}</h1>
    <p class="mt-2 text-sm text-gray-600">{{ __('front.account.member.favorites_description') }}</p>
</div>

<!-- Favorites Grid -->
@if($favorites->count() > 0)
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($favorites as $profile)
    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group relative">
        <!-- Profile Image -->
        <div class="relative">
            <!-- Verified Badge -->
            @if($profile->isVerified()) 
            <div class="absolute top-3 left-3 flex flex-col items-start gap-1 z-20">
                <div class="bg-green-100 text-green-500 p-1 px-0.5 rounded-xl flex flex-wrap justify-center">
                    <x-icons name="camera" class="w-5 h-5" />
                    <p class="text-xs font-bold w-full text-center">{{ __('front.profiles.list.verified') }}</p>
                </div>
            </div>
            @endif

            <!-- VIP Badge -->
            @if($profile->isVip())
            <div class="absolute top-3 right-3 z-20">
                <div class="bg-gold-500 text-white px-2 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                    <x-icons name="star" class="w-3 h-3" />
                    VIP
                </div>
            </div>
            @endif

            <!-- Profile Photo -->
            <a href="{{ route('profiles.show', $profile) }}" class="block aspect-[4/5] bg-gradient-to-br from-primary-100 to-secondary-100 relative overflow-hidden">
                @if($profile->getAllImages()->count() > 0)
                <img src="{{ $profile->getFirstImageUrl() }}" alt="{{ $profile->display_name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                <!-- No image placeholder -->
                <div class="flex items-center justify-center w-full h-full">
                    <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                @endif
            </a>
        </div>

        <!-- Profile Info -->
        <div class="p-4 space-y-3">
            <!-- Name -->
            <div class="flex items-center justify-between">
                <h4 class="text-gray-700 font-medium truncate">{{ $profile->display_name }}</h4>
                @if($profile->age)
                <span class="text-sm text-gray-500">{{ $profile->age }} {{ __('front.profiles.list.years') }}</span>
                @endif
            </div>

            <!-- Location -->
            @if($profile->city)
            <div class="flex items-center gap-2 text-sm text-primary-600">
                <x-icons name="location" class="w-4 h-4" />
                <span>{{ $profile->city }}</span>
            </div>
            @endif

            <!-- Rating -->
            <div class="flex items-center gap-2">
                @if($profile->getTotalRatings() > 0)
                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <span class="text-sm font-bold text-gray-900">{{ number_format($profile->getAverageRating(), 1) }}</span>
                <span class="text-xs text-gray-500">({{ $profile->getTotalRatings() }})</span>
                @else
                <span class="text-xs text-gray-500">{{ __('front.profiles.rating.no_ratings') }}</span>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 pt-2">
                <a href="{{ route('profiles.show', $profile) }}"
                    class="flex-1 py-2 px-4 rounded-lg bg-secondary-600 hover:bg-secondary-700 text-white text-sm font-medium text-center transition-colors duration-200">
                    {{ __('front.profiles.list.detail') }}
                </a>
                <form action="{{ route('account.member.favorites.remove', $profile) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="p-2 rounded-lg bg-pink-100 text-pink-600 hover:bg-pink-200 transition-colors duration-200"
                        title="{{ __('front.favorites.remove') }}">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
@if($favorites->hasPages())
<div class="mt-8">
    {{ $favorites->links() }}
</div>
@endif

@else
<!-- Empty State -->
<div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('front.favorites.no_favorites') }}</h3>
    <p class="text-gray-500 mb-6">{{ __('front.favorites.no_favorites_description') }}</p>
    <a href="{{ route('profiles.index') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        {{ __('front.favorites.browse_profiles') }}
    </a>
</div>
@endif
@endsection
