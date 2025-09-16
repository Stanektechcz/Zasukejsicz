@props(['color' => 'primary', 'size' => 'md', 'href' => null])

@php
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
        default => 'px-5 py-4 text-sm',
    };

    $colorClasses = match($color) {
        'secondary' => 'bg-secondary-600 text-white hover:bg-secondary-700 focus:ring-secondary-500',
        default => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500',
    };

    $classes = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed shadow hover:shadow-md ' . $sizeClasses . ' ' . $colorClasses;
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
