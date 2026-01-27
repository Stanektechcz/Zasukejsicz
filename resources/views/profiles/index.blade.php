@extends('layouts.app')

@section('title', __('front.title'))

@section('content')
<!-- Hero Section  max-w-[1331px] -->
<div class="min-h-[420px] md:min-h-[520px] mx-auto rounded-b-3xl bg-center bg-cover" style="background-image: url('/images/header.png');">
    <div class="container mx-auto px-4 pt-16 md:pt-24 pb-8 flex flex-col min-h-[420px] md:min-h-[520px]">
        <div class="max-w-2xl px-4 md:pl-16 py-10 md:py-16">
            <h1 class="text-secondary leading-tight text-3xl sm:text-4xl md:text-6xl py-4 md:py-5">
                {{ __('front.landing.wearecommunity') }}
                <span class="text-primary-500">{{ __('front.landing.fucking') }}.</span>
            </h1>

            <p class="text-lg sm:text-xl text-gray-600 mb-6 md:mb-8 max-w-sm">
                {{ __('front.landing.girlsregisternow') }}
            </p>
        </div>

        <div class="mt-auto px-0">
            <!-- Search Card -->
            <livewire:search-profiles />
        </div>
    </div>
</div>

<!-- Profiles Section -->

<div class="container mx-auto px-4 pt-20">
    <livewire:profile-list />
</div>

<!-- Blog pages list gallery -->
<x-blog-listing :posts="$blogPosts" />


<div class="-z-10 absolute top-[620px] left-0 right-0 -bottom-1 overflow-x-hidden">
    <div class="radial-blur"></div>
    <div class="radial-blur-secondary radial-blur-right"></div>
    <div class="radial-blur-secondary "></div>
</div>

@endsection