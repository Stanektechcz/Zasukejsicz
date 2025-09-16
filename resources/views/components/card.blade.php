@props(['hover' => true])

@php
    $hoverClasses = match($hover) {
        true => 'hover:shadow-md transition-shadow duration-200',
        default => '',
    };

    $classes = 'bg-white rounded-2xl shadow overflow-hidden ' . $hoverClasses;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
