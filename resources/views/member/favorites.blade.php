@extends('layouts.member')

@section('member-content')
<!-- Page Title -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">{{ __('front.account.member.favorites') }}</h1>
    <p class="mt-2 text-sm text-gray-600">{{ __('front.account.member.favorites_description') }}</p>
</div>

<!-- Placeholder Content -->
<div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('front.account.member.coming_soon') }}</h3>
    <p class="text-gray-500">{{ __('front.account.member.feature_coming_soon') }}</p>
</div>
@endsection
