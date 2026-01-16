@extends('layouts.app')

@section('title', __('front.title'))

@section('content')
<!-- Hero Section  max-w-[1331px] -->
<div class="max-h-[620px] mx-auto rounded-b-3xl" style="background-image: url('/images/header.png'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-4 pt-24">
        <div class="max-w-2xl pl-16 py-16">
            <h1 class="text-secondary leading-tight  text-4xl md:text-6xl py-5">
                {{ __('front.landing.wearecommunity') }}
                <span class="text-primary-500">{{ __('front.landing.fucking') }}.</span>
            </h1>

            <p class="text-xl text-gray-600 mb-8 max-w-sm">
                {{ __('front.landing.girlsregisternow') }}
            </p>
        </div>
        <!-- Search Card -->
        <livewire:search-profiles />

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