@props(['name', 'class' => '', 'strokeWidth' => 1.5])

@php
    $iconPath = public_path("images/icons/{$name}.svg");
@endphp

@if (file_exists($iconPath))
    <span {{ $attributes->merge(['class' => trim('inline-block ' . $class)]) }}>
        {!! preg_replace([
            '/\bstroke="[^"]*"/',
            '/\bwidth="[^"]*"/',
            '/\bheight="[^"]*"/',
            '/\bfill="[^"]*"/',
            '/<svg/'
        ], [
            'stroke="currentColor"',
            '',
            '',
            'fill="none"',
            '<svg stroke-width="' . ($strokeWidth) . '" '
        ], file_get_contents($iconPath)) !!}
    </span>
@else
    <!-- Icon not found: {{ $name }} -->
@endif