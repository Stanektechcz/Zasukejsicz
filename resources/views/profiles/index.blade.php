@extends('layouts.app')

@section('title', __('Find Your Perfect Massage Therapist'))

@section('content')
<!-- Hero Section -->
<div class="max-h-[640px]" style="background-image: url('/images/header.jpg'); background-size: cover; background-position: center;">
     <x-section class="pt-24">
     
         <div class="container mx-auto px-4 pt-14" style="min-height: calc(100vh - 20rem);">
             <div class="max-w-xl py-20">
                 <x-heading size="h1" class="text-secondary text-4xl md:text-6xl mb-6 py-10">
                     {{ __('front.landing.wearecommunity') }}
                     <span class="text-primary-500">{{ __('front.landing.fucking') }}.</span>
                 </x-heading>
     
                 <p class="text-xl text-gray-600 mb-8 max-w-2xl">
                     {{ __('front.landing.girlsregisternow') }}
                 </p>
             </div>
             <!-- Search Card -->
             <div>
                 <x-search-card :cities="$cities" />
             </div>
     
         </div>
     </x-section>
 </div>

<!-- Profiles Section -->
<x-section>
    <div class="container mx-auto px-4">
        <!-- Alpine.js Reactive Profile List -->
        <x-profile-list :initialProfiles="$profiles" />
    </div>
</x-section>
@endsection