@props(['name', 'class' => '', 'strokeWidth' => 1.5, 'fill' => false, 'block' => true])

@php
    $iconPath = public_path("images/icons/{$name}.svg");
@endphp

@if (file_exists($iconPath))
    <span {{ $attributes->merge(['class' => trim(($block == "false" ? 'inline' : 'inline-block') . ' ' . $class)]) }}>
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
            $fill ? 'fill="currentColor"' : 'fill="none"',
            '<svg stroke-width="' . ($strokeWidth) . '" '
        ], file_get_contents($iconPath)) !!}
    </span>
@else
    <!-- Icon not found: {{ $name }} -->
@endif