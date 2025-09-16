@props(['cities' => collect()])

<x-card class="w-full shadow-2xl p-8 overflow-visible" :hover="false">
    <div class="space-y-6">
        <!-- Heading -->
        <x-heading size="h4" class="text-center mb-6">
            <svg class="inline-block w-8 h-8 text-primary-500 mr-2 align-middle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            
            {{ __('Find Profiles') }}
        </x-heading>

        <!-- Search Form -->
        <form method="GET" action="{{ route('profiles.index') }}" class="space-y-6" id="search-form">


            <!-- Age Range and Search Button in Single Row -->
            <div class="flex items-end gap-4">
                <!-- City Picker -->
                <div class="space-y-2">
                    <label for="city">
                        {{ __('City') }}
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="city"
                            name="city"
                            value="{{ request('city') }}"
                            placeholder="{{ __('Enter or select a city...') }}"
                            class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200"
                            autocomplete="off">

                        <!-- City Dropdown -->
                        <div id="city-dropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-auto">
                            @foreach($cities as $city)
                            <div class="city-option px-4 py-2 hover:bg-primary-50 cursor-pointer text-text-default hover:text-primary-600 transition-colors" data-city="{{ $city }}">
                                {{ $city }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <label>
                        {{ __('Age Range') }}
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <select name="age_min"
                                class="form-select w-full px-4 py-3 text-lg border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                <option value="">{{ __('Min Age') }}</option>
                                @for($age = 20; $age <= 60; $age +=5)
                                    <option value="{{ $age }}" {{ request('age_min') == $age ? 'selected' : '' }}>{{ $age }}+</option>
                                    @endfor
                            </select>
                        </div>
                        <div>
                            <select name="age_max"
                                class="form-select w-full px-4 py-3 text-lg border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                <option value="">{{ __('Max Age') }}</option>
                                @for($age = 25; $age <= 65; $age +=5)
                                    <option value="{{ $age }}" {{ request('age_max') == $age ? 'selected' : '' }}>{{ $age }}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="pt-6 flex-shrink-0">

                    <a href="#" class="btn btn-primary w-full text-lg py-5 px-8 flex items-center justify-center">
                        {{ __('Search') }}
                        <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-card>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cityInput = document.getElementById('city');
        const cityDropdown = document.getElementById('city-dropdown');
        const cityOptions = document.querySelectorAll('.city-option');

        // Show dropdown on focus
        cityInput.addEventListener('focus', function() {
            cityDropdown.classList.remove('hidden');
        });

        // Filter cities on input
        cityInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let hasVisibleOptions = false;

            cityOptions.forEach(option => {
                const cityName = option.dataset.city.toLowerCase();
                if (cityName.includes(searchTerm)) {
                    option.style.display = 'block';
                    hasVisibleOptions = true;
                } else {
                    option.style.display = 'none';
                }
            });

            if (hasVisibleOptions && searchTerm.length > 0) {
                cityDropdown.classList.remove('hidden');
            } else if (searchTerm.length === 0) {
                cityDropdown.classList.remove('hidden');
                cityOptions.forEach(option => option.style.display = 'block');
            } else {
                cityDropdown.classList.add('hidden');
            }
        });

        // Select city on click
        cityOptions.forEach(option => {
            option.addEventListener('click', function() {
                cityInput.value = this.dataset.city;
                cityDropdown.classList.add('hidden');
            });
        });

        // Hide dropdown on outside click
        document.addEventListener('click', function(event) {
            if (!cityInput.contains(event.target) && !cityDropdown.contains(event.target)) {
                cityDropdown.classList.add('hidden');
            }
        });
    });
</script>