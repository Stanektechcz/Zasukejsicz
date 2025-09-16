@props(['size' => 'h1', 'color' => 'default'])

@php
    $colorClass = match($color) {
        'primary' => 'text-primary-600',
        'secondary' => 'text-secondary-600',
        'white' => 'text-white',
        default => 'text-secondary',
    };
@endphp

@if($size === 'h1')
    <h1 class="font-bold leading-tight mb-4 text-3xl md:text-4xl lg:text-5xl  {{ $colorClass }}">
        {{ $slot }}
    </h1>
@elseif($size === 'h2')
    <h2 class="font-bold leading-tight mb-4 text-2xl md:text-3xl lg:text-4xl {{ $colorClass }}">
        {{ $slot }}
    </h2>
@elseif($size === 'h3')
    <h3 class="font-bold leading-tight mb-4 text-xl md:text-2xl lg:text-3xl {{ $colorClass }}">
        {{ $slot }}
    </h3>
@elseif($size === 'h4')
    <h4 class="font-bold leading-tight mb-4 text-lg md:text-xl lg:text-2xl {{ $colorClass }}">
        {{ $slot }}
    </h4>
@else
    <h1 class="font-bold leading-tight mb-4 text-3xl md:text-4xl lg:text-5xl {{ $colorClass }}">
        {{ $slot }}
    </h1>
@endif
