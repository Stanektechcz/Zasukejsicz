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
            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Osobní údaje</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Jméno *</label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        class="input-control mt-1 @error('name') border-red-500 @enderror"
                        placeholder="Vaše jméno">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail *</label>
                    <input
                        type="email"
                        id="email"
                        wire:model="email"
                        class="input-control mt-1 @error('email') border-red-500 @enderror"
                        placeholder="vas@email.cz">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
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
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Můj profil</h3>

            @if($hasProfile)
            <div class="space-y-6">
                <!-- Display Name -->
                <div>
                    <label for="display_name" class="block text-sm font-medium text-gray-700 mb-2">Zobrazované jméno</label>
                    <input
                        type="text"
                        id="display_name"
                        wire:model="display_name"
                        class="input-control mt-1 @error('display_name') border-red-500 @enderror"
                        placeholder="Jak se máte zobrazovat na profilu">
                    @error('display_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Pohlaví</label>
                        <x-autocomplete-select
                            name="gender"
                            label=""
                            placeholder="Vyberte pohlaví"
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
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-2">Věk</label>
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
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Město</label>
                        <input
                            type="text"
                            id="city"
                            wire:model="city"
                            class="input-control mt-1 @error('city') border-red-500 @enderror"
                            placeholder="Vaše město">
                        @error('city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Adresa</label>
                    <input
                        type="text"
                        id="address"
                        wire:model="address"
                        class="input-control mt-1 @error('address') border-red-500 @enderror"
                        placeholder="Ulice a číslo popisné">
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- About -->
                <div>
                    <label for="about" class="block text-sm font-medium text-gray-700 mb-2">O mně</label>
                    <textarea
                        id="about"
                        wire:model="about"
                        rows="4"
                        class="input-control mt-1 @error('about') border-red-500 @enderror"
                        placeholder="Napište něco o sobě..."></textarea>
                    @error('about') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Availability Hours -->
                <div>
                    <label for="availability_hours" class="block text-sm font-medium text-gray-700 mb-2">Dostupné hodiny</label>
                    <input
                        type="text"
                        id="availability_hours"
                        wire:model="availability_hours"
                        class="input-control mt-1 @error('availability_hours') border-red-500 @enderror"
                        placeholder="Například: Po-Pá 9:00-17:00">
                    @error('availability_hours') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Profile Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Stav profilu</label>
                    <select
                        id="status"
                        wire:model="status"
                        class="input-control mt-1 @error('status') border-red-500 @enderror">
                        <option value="">Vyberte stav</option>
                        <option value="pending">Čeká na schválení</option>
                        <option value="approved">Schváleno</option>
                        <option value="rejected">Zamítnuto</option>
                    </select>
                    @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Public Profile Toggle -->
                <div class="flex items-center justify-between">
                    <div>
                        <label for="is_public" class="text-sm font-medium text-gray-700">Veřejný profil</label>
                        <p class="text-xs text-gray-500">Můj profil je viditelný pro ostatní uživatele</p>
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
                    <p class="text-gray-600 text-lg">Zatím nemáte vytvořený profil</p>
                    <p class="text-gray-500 text-sm mt-2">Vyplňte níže uvedené údaje a vytvořte si svůj profil</p>
                </div>

                <!-- Profile Creation Form -->
                <!-- Display Name -->
                <div>
                    <label for="display_name" class="block text-sm font-medium text-gray-700 mb-2">Zobrazované jméno</label>
                    <input
                        type="text"
                        id="display_name"
                        wire:model="display_name"
                        class="input-control mt-1 @error('display_name') border-red-500 @enderror"
                        placeholder="Jak se máte zobrazovat na profilu">
                    @error('display_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Pohlaví</label>
                        <x-autocomplete-select
                            name="gender"
                            label=""
                            placeholder="Vyberte pohlaví"
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
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-2">Věk</label>
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
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Město</label>
                        <input
                            type="text"
                            id="city"
                            wire:model="city"
                            class="input-control mt-1 @error('city') border-red-500 @enderror"
                            placeholder="Vaše město">
                        @error('city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Adresa</label>
                    <input
                        type="text"
                        id="address"
                        wire:model="address"
                        class="input-control mt-1 @error('address') border-red-500 @enderror"
                        placeholder="Ulice a číslo popisné">
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- About -->
                <div>
                    <label for="about" class="block text-sm font-medium text-gray-700 mb-2">O mně</label>
                    <textarea
                        id="about"
                        wire:model="about"
                        rows="4"
                        class="input-control mt-1 @error('about') border-red-500 @enderror"
                        placeholder="Napište něco o sobě..."></textarea>
                    @error('about') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Availability Hours -->
                <div>
                    <label for="availability_hours" class="block text-sm font-medium text-gray-700 mb-2">Dostupné hodiny</label>
                    <input
                        type="text"
                        id="availability_hours"
                        wire:model="availability_hours"
                        class="input-control mt-1 @error('availability_hours') border-red-500 @enderror"
                        placeholder="Například: Po-Pá 9:00-17:00">
                    @error('availability_hours') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Public Profile Toggle -->
                <div class="flex items-center justify-between">
                    <div>
                        <label for="is_public" class="text-sm font-medium text-gray-700">Veřejný profil</label>
                        <p class="text-xs text-gray-500">Můj profil je viditelný pro ostatní uživatele</p>
                    </div>
                    <x-toggle-switch
                        name="is_public"
                        id="is_public"
                        wire-model="is_public"
                        :checked="$is_public" />
                </div>
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
                <span wire:loading.remove>Uložit změny</span>
                <span wire:loading>Ukládám...</span>
            </button>
        </div>
    </form>

</div>