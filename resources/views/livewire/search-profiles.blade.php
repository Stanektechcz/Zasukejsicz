<div class="card w-full shadow-3xl shadow p-8 overflow-visible">
    <div class="space-y-6">
        <!-- Heading -->
        <h4 class="mb-6 flex items-center">
            <x-icons name="heart" class="w-6 h-6 inline-block mr-3 text-primary-500" />
            {{ __('front.landing.findprofiles') }}
        </h4>

        <!-- Search Form -->
        <form wire:submit.prevent="search" class="space-y-6">
            <!-- Search Controls Row -->
            <div class="flex flex-wrap items-end gap-4">
                <!-- City Picker -->
                <div class="flex-1">
                    <x-autocomplete-select
                        name="city"
                        label="{{ __('front.profiles.search.city') }}"
                        :options="collect($this->filteredCities)->mapWithKeys(fn($city) => [$city => $city])->toArray()"
                        :value="$city"
                        placeholder="{{ __('front.profiles.search.entercity') }}"
                        wire-model="city"
                        wire-focus="showDropdown"
                        wire-click="clearAndShowDropdown"
                        dropdown-open="{{ $showCityDropdown }}"
                        close-dropdown="$wire.set('showCityDropdown', false)"
                        select-method="selectCity"
                        :searchable="true" /> <!-- Age Range -->
                </div>

                <div class="w-full md:w-3/12">
                    <label>
                        {{ __('front.profiles.search.agerange') }}
                    </label>
                    <div class="">
                        <!-- Age Range -->
                        <x-autocomplete-select
                            name="age_range"
                            label=""
                            :options="$this->ageRangeOptions"
                            :value="$age_range"
                            placeholder="{{ __('front.profiles.search.selectage') }}"
                            wire-click="clearAndShowAgeRangeDropdown"
                            dropdown-open="{{ $showAgeRangeDropdown }}"
                            close-dropdown="$wire.set('showAgeRangeDropdown', false)"
                            select-method="selectAgeRange"
                            :searchable="false" />
                    </div>
                </div>

                <!-- Search Button -->
                <div class="pt-6 flex-shrink-0">
                    <button
                        type="submit"
                        class="btn-primary w-full text-lg py-5 px-8 flex items-center justify-center"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-75">

                        <!-- Loading spinner -->
                        <span wire:loading wire:target="search" class="mr-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>

                        <span wire:loading.remove wire:target="search">
                            {{ __('front.profiles.search.search') }}
                        </span>
                        <span wire:loading wire:target="search">
                            {{ __('front.profiles.search.searching') }}
                        </span>

                        <!-- Search Icon -->
                        <svg wire:loading.remove wire:target="search" class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>