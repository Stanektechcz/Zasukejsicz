<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Browse Profiles</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Browse Massage Profiles
                    </h1>
                    <div class="space-x-4">
                        <a href="{{ route('filament.admin.auth.login') }}" class="text-blue-600 hover:text-blue-800">Admin Login</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <select name="city" id="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Cities</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="age_min" class="block text-sm font-medium text-gray-700">Min Age</label>
                        <input type="number" name="age_min" id="age_min" 
                               value="{{ request('age_min') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="age_max" class="block text-sm font-medium text-gray-700">Max Age</label>
                        <input type="number" name="age_max" id="age_max" 
                               value="{{ request('age_max') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="flex items-end">
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="verified" value="1" 
                                       {{ request()->boolean('verified') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Verified Only</span>
                            </label>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Count -->
            <div class="mb-4">
                <p class="text-sm text-gray-700">
                    Showing {{ $profiles->firstItem() ?? 0 }} to {{ $profiles->lastItem() ?? 0 }} 
                    of {{ $profiles->total() }} profiles
                </p>
            </div>

            <!-- Profile Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($profiles as $profile)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-200">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $profile->display_name }}
                                </h3>
                                @if($profile->isVerified())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Verified
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-2">
                                @if($profile->age)
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Age:</span> {{ $profile->age }}
                                    </p>
                                @endif

                                @if($profile->city)
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">City:</span> {{ $profile->city }}
                                    </p>
                                @endif

                                @if($profile->about)
                                    <p class="text-sm text-gray-600 line-clamp-3">
                                        {{ Str::limit($profile->about, 120) }}
                                    </p>
                                @endif
                            </div>

                            @if($profile->availability_hours)
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Availability</h4>
                                    <div class="text-xs text-gray-600 space-y-1">
                                        @foreach(array_slice($profile->availability_hours, 0, 3, true) as $day => $hours)
                                            <div class="flex justify-between">
                                                <span>{{ $day }}</span>
                                                <span>{{ $hours }}</span>
                                            </div>
                                        @endforeach
                                        @if(count($profile->availability_hours) > 3)
                                            <p class="text-center text-gray-500 italic">
                                                +{{ count($profile->availability_hours) - 3 }} more days
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A9.971 9.971 0 0124 24a9.971 9.971 0 019.287 6.286" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No profiles found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Try adjusting your filters to see more results.
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($profiles->hasPages())
                <div class="mt-8">
                    {{ $profiles->links() }}
                </div>
            @endif
        </main>
    </div>

    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>
</html>
