@extends('layouts.member')

@section('member-content')
<!-- Page Title -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">{{ __('front.account.member.ratings') }}</h1>
    <p class="mt-2 text-sm text-gray-600">{{ __('front.account.member.ratings_description') }}</p>
</div>

<!-- Placeholder Content -->
<div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
    </svg>
    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('front.account.member.coming_soon') }}</h3>
    <p class="text-gray-500">{{ __('front.account.member.feature_coming_soon') }}</p>
</div>
@endsection
