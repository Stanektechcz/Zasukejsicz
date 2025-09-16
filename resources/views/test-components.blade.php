<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Component Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light-bg min-h-screen">
    <div class="container mx-auto py-8 space-y-8">
        <!-- Headings Test -->
        <x-section>
            <x-heading size="h1" color="primary">Primary H1 Heading</x-heading>
            <x-heading size="h2" color="secondary">Secondary H2 Heading</x-heading>
            <x-heading size="h3">Default H3 Heading</x-heading>
        </x-section>

        <!-- Buttons Test -->
        <x-section>
            <x-heading size="h2">Button Variations</x-heading>
            <div class="flex flex-wrap gap-4 mt-4">
                
            </div>
        </x-section>

        <!-- Nested Sections Test -->
        <x-section>
            <x-heading size="h2" color="primary">Section with Content</x-heading>
            <p class="text-gray-600 mb-4">This is a test of our component system using the brand colors:</p>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Primary Pink: rgba(221, 56, 136, 1)</li>
                <li>Secondary Purple: rgba(92, 45, 98, 1)</li>
                <li>Light Background: rgba(248, 249, 249, 1)</li>
                <li>Poppins Font Family</li>
            </ul>
        </x-section>
    </div>
</body>
</html>
