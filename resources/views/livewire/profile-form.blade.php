<div>


    @if (session()->has('message'))
    <div class="alert alert-success flex items-center justify-between my-3">
        <div class="flex items-center font-semibold">
            <x-icons name="bell" class="w-5 h-5 mr-2.5" />
            <span>{{ session('message') }}</span>
        </div>
        <button type="button" class="flex items-center ml-2 text-gray-400 hover:text-gray-600" onclick="this.parentElement.remove()">
            <x-icons name="cross" class="text-green-800 w-3 h-3" />
        </button>
    </div>
    @endif



    <form wire:submit="save" class="space-y-8">
        <!-- Personal Information Section -->
        <div class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.name') }} *</label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        class="input-control mt-1 @error('name') border-red-500 @enderror"
                        placeholder="{{ __('front.profiles.form.name') }}">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.email') }} *</label>
                    <input
                        type="email"
                        id="email"
                        wire:model="email"
                        class="input-control mt-1 @error('email') border-red-500 @enderror"
                        placeholder="your@email.com">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.phone') }}</label>
                    <input
                        type="tel"
                        id="phone"
                        wire:model="phone"
                        class="input-control mt-1 @error('phone') border-red-500 @enderror"
                        placeholder="+420 123 456 789">
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="space-y-6 pt-10">
            <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">{{ __('front.profiles.form.profile') }}</h3>

            @if($hasProfile)
            <div class="space-y-6">
                <!-- Display Name -->
                <div>
                    <label for="display_name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.displayname') }}</label>
                    <input
                        type="text"
                        id="display_name"
                        wire:model="display_name"
                        class="input-control mt-1 @error('display_name') border-red-500 @enderror"
                        placeholder="{{ __('front.profiles.form.displayname') }}">
                    @error('display_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.gender') }}</label>
                        <x-autocomplete-select
                            name="gender"
                            label=""
                            placeholder="{{ __('front.profiles.form.selectgender') }}"
                            :searchable="false"
                            :value="$gender"
                            :options="$genders"
                            wire-click="toggleGenderDropdown"
                            :dropdown-open="$genderDropdownOpen"
                            select-method="selectGender"
                            close-dropdown="genderDropdownOpen = false" />
                        @error('gender') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Age -->
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.age') }}</label>
                        <input
                            type="number"
                            id="age"
                            wire:model="age"
                            min="18"
                            max="120"
                            class="input-control mt-1 @error('age') border-red-500 @enderror"
                            placeholder="25">
                        @error('age') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.city') }}</label>
                        <input
                            type="text"
                            id="city"
                            wire:model="city"
                            class="input-control mt-1 @error('city') border-red-500 @enderror"
                            placeholder="{{ __('front.profiles.form.city') }}">
                        @error('city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.address') }}</label>
                    <input
                        type="text"
                        id="address"
                        wire:model="address"
                        class="input-control mt-1 @error('address') border-red-500 @enderror"
                        placeholder="{{ __('front.profiles.form.street') }}">
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- About -->
                <div>
                    <label for="about" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.aboutme') }}</label>
                    <textarea
                        id="about"
                        wire:model="about"
                        rows="4"
                        class="input-control mt-1 @error('about') border-red-500 @enderror"
                        placeholder="{{ __('front.profiles.form.aboutmeplaceholder') }}"></textarea>
                    @error('about') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Availability Hours -->
                <div>
                    <label for="availability_hours" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.availability') }}</label>
                    <input
                        type="text"
                        id="availability_hours"
                        wire:model="availability_hours"
                        class="input-control mt-1 @error('availability_hours') border-red-500 @enderror"
                        placeholder="{{ __('front.profiles.form.availabilityplaceholder') }}">
                    @error('availability_hours') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Profile Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.status') }}</label>
                    <select
                        id="status"
                        wire:model="status"
                        class="input-control mt-1 @error('status') border-red-500 @enderror">
                        <option value="">{{ __('front.profiles.form.selectstatus') }}</option>
                        <option value="pending">{{ __('front.profiles.form.pending') }}</option>
                        <option value="approved">{{ __('front.profiles.form.approved') }}</option>
                        <option value="rejected">{{ __('front.profiles.form.rejected') }}</option>
                    </select>
                    @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Public Profile Toggle -->
                <div class="flex items-center justify-between">
                    <div>
                        <label for="is_public" class="text-sm font-medium text-gray-700">{{ __('front.profiles.form.public') }}</label>
                        <p class="text-xs text-gray-500">{{ __('front.profiles.form.publicdesc') }}</p>
                    </div>
                    <x-toggle-switch
                        name="is_public"
                        id="is_public"
                        wire-model="is_public"
                        :checked="$is_public" />
                </div>
            </div>
            @else
            <div class="space-y-6">
                <!-- No Profile Message -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center mb-6">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <p class="text-gray-600 text-lg">{{ __('front.profiles.form.noprofile') }}</p>
                    <p class="text-gray-500 text-sm mt-2">{{ __('front.profiles.form.createprofile') }}</p>
                </div>

                <!-- Profile Creation Form -->
                <!-- Display Name -->
                <div>
                    <label for="display_name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.displayname') }}</label>
                    <input
                        type="text"
                        id="display_name"
                        wire:model="display_name"
                        class="input-control mt-1 @error('display_name') border-red-500 @enderror"
                        placeholder="{{ __('front.profiles.form.displayname') }}">
                    @error('display_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.gender') }}</label>
                        <x-autocomplete-select
                            name="gender"
                            label=""
                            placeholder="{{ __('front.profiles.form.selectgender') }}"
                            :searchable="false"
                            :value="$gender"
                            :options="$genders"
                            wire-click="toggleGenderDropdown"
                            :dropdown-open="$genderDropdownOpen"
                            select-method="selectGender"
                            close-dropdown="genderDropdownOpen = false" />
                        @error('gender') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Age -->
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.age') }}</label>
                        <input
                            type="number"
                            id="age"
                            wire:model="age"
                            min="18"
                            max="120"
                            class="input-control mt-1 @error('age') border-red-500 @enderror"
                            placeholder="25">
                        @error('age') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.city') }}</label>
                        <input
                            type="text"
                            id="city"
                            wire:model="city"
                            class="input-control mt-1 @error('city') border-red-500 @enderror"
                            placeholder="{{ __('front.profiles.form.city') }}">
                        @error('city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.address') }}</label>
                    <input
                        type="text"
                        id="address"
                        wire:model="address"
                        class="input-control mt-1 @error('address') border-red-500 @enderror"
                        placeholder="{{ __('front.profiles.form.street') }}">
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- About -->
                <div>
                    <label for="about" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.aboutme') }}</label>
                    <textarea
                        id="about"
                        wire:model="about"
                        rows="4"
                        class="input-control mt-1 @error('about') border-red-500 @enderror"
                        placeholder="{{ __('front.profiles.form.aboutmeplaceholder') }}"></textarea>
                    @error('about') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Availability Hours -->
                <div>
                    <label for="availability_hours" class="block text-sm font-medium text-gray-700 mb-2">{{ __('front.profiles.form.availability') }}</label>
                    <input
                        type="text"
                        id="availability_hours"
                        wire:model="availability_hours"
                        class="input-control mt-1 @error('availability_hours') border-red-500 @enderror"
                        placeholder="{{ __('front.profiles.form.availabilityplaceholder') }}">
                    @error('availability_hours') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Public Profile Toggle -->
                <!-- 
                <div class="flex items-center justify-between">
                    <div>
                        <label for="is_public" class="text-sm font-medium text-gray-700">{{ __('front.profiles.form.public') }}</label>
                        <p class="text-xs text-gray-500">{{ __('front.profiles.form.publicdesc') }}</p>
                    </div>
                    <x-toggle-switch
                        name="is_public"
                        id="is_public"
                        wire-model="is_public"
                        :checked="$is_public" />
                </div> -->
            </div>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed"
                class="btn-primary btn-small justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span wire:loading.remove>{{ __('front.profiles.form.savechanges') }}</span>
                <span wire:loading>{{ __('front.profiles.form.saving') }}</span>
            </button>
        </div>
    </form>

</div>