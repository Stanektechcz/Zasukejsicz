@props(['background' => 'default'])

@php
    $backgroundClasses = match($background) {
        'white' => 'bg-white',
        'light' => 'bg-grey-50',
        default => '',
    };

    $classes = 'py-12 md:py-16 lg:py-20 ' . $backgroundClasses;
@endphp

<section {{ $attributes->merge(['class' => $classes]) }}>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </div>
</section>
