@extends('layouts.app')

@section('title', __('Find Your Perfect Massage Therapist'))

@section('content')
<!-- Hero Section -->
<div class="max-h-[650px] rounded-b-3xl" style="background-image: url('/images/header.png'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-4 pt-24" >
        <div class="max-w-2xl py-16">
            <h1 class="text-secondary text-4xl md:text-6xl py-5">
                {{ __('front.landing.wearecommunity') }}
                <span class="text-primary-500">{{ __('front.landing.fucking') }}.</span>
            </h1>

            <p class="text-xl text-gray-600 mb-8 max-w-sm">
                {{ __('front.landing.girlsregisternow') }}
            </p>
        </div>
        <!-- Search Card -->
        <div>
            <x-search-card :cities="$cities" />
        </div>

    </div>
</div>

<!-- Profiles Section -->

<div class="container mx-auto px-4 pt-20">
    <!-- Alpine.js Reactive Profile List -->
    <x-profile-list :initialProfiles="$profiles" />
</div>

@endsection