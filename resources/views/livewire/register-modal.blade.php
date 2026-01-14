<div x-data="{ show: false, closing: false }"
    x-on:show-register-modal.window="show = true"
    x-on:hide-register-modal.window="show = false; closing = false"
    x-init="$watch('show', v => document.body.style.overflow = v ? 'hidden' : '')">
    <!-- Registration Modal -->
    <div x-show="show"
        x-transition.opacity.duration.300ms
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4">

        <!-- Modal Backdrop -->
        <div class="modal-backdrop"
            @click="closing = true; show = false"></div>

        <!-- Modal Content -->
        <div class="modal-container pb-5 sm:pb-7">
            <!-- Step Back Button (only on step 2) -->
            @if($currentStep === 2)
            <button wire:click="previousStep"
                class="modal-back-btn">
                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            @endif

            <!-- Close Button -->
            <button @click="closing = true; show = false"
                class="modal-close-btn">
                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            @if($currentStep === 1)
            <!-- Step 1: Gender Selection -->
            <div class="text-center">
                <!-- Header -->
                <div class="modal-header">
                    <h1 class="modal-title">{{ __('auth.register.title') }}</h1>
                </div>

                <!-- Gender Options -->
                <div class="space-y-3 sm:space-y-4 max-w-md mx-auto">
                    <!-- Female Option -->
                    <button wire:click="selectGender('female')"
                        class="w-full p-4 sm:p-6 rounded-xl sm:rounded-2xl bg-white shadow-lg transition-all duration-200 hover:shadow-xl {{ $gender === 'female' ? 'border-primary-500' : 'border-gray-200' }}">
                        <div class="flex items-center justify-between">
                            <div class="text-left">
                                <h3 class="text-base sm:text-lg m-0 font-bold text-secondary">{{ __('auth.register.gender_selection.female_title') }}</h3>
                                <p class="text-xs sm:text-sm text-gray-500">{{ __('auth.register.gender_selection.female_subtitle') }}</p>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-gray-100 rounded-full p-1.5 sm:p-2 flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary transform transition-transform {{ $gender === 'female' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </button>

                    <!-- Male Option -->
                    <button wire:click="selectGender('male')"
                        class="w-full p-4 sm:p-6 rounded-xl sm:rounded-2xl bg-white shadow-lg transition-all duration-200 hover:shadow-xl {{ $gender === 'male' ? 'border-primary-500' : 'border-gray-200' }}">
                        <div class="flex items-center justify-between">
                            <div class="text-left">
                                <h3 class="text-base sm:text-lg m-0 font-bold text-secondary">{{ __('auth.register.gender_selection.male_title') }}</h3>
                                <p class="text-xs sm:text-sm text-gray-500">{{ __('auth.register.gender_selection.male_subtitle') }}</p>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-gray-100 rounded-full p-1.5 sm:p-2 flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary transform transition-transform {{ $gender === 'male' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </button>
                </div>

                @error('gender')
                <p class="form-error mt-4">{{ $message }}</p>
                @enderror
            </div>

            @elseif($currentStep === 2)
            <!-- Step 2: Registration Form -->
            <div>
                <!-- Header -->
                <div class="modal-header">
                    <h1 class="modal-title">{{ __('auth.register.title') }}</h1>
                    <h2 class="modal-subtitle">
                        @if($gender === 'female')
                            {{ __('auth.register.subtitle_female') }}
                        @elseif($gender === 'male')
                            {{ __('auth.register.subtitle_male') }}
                        @endif
                    </h2>
                </div>

                <!-- Form -->
                <form wire:submit="register" class="form-container space-y-2.5 sm:space-y-3">
                    <!-- Registration Error -->
                    @error('registration')
                    <div class="form-alert">
                        {{ $message }}
                    </div>
                    @enderror
                    <!-- Name -->
                    <div>
                        <label class="form-label">{{ __('auth.register.form.username_label') }}</label>
                        <input wire:model="name"
                            type="text"
                            required
                            class="form-field {{ $errors->has('name') ? 'form-field-error' : '' }}">
                        @error('name')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="form-label">{{ __('auth.register.form.email_label') }}</label>
                        <input wire:model="email"
                            type="email"
                            required
                            class="form-field {{ $errors->has('email') ? 'form-field-error' : '' }}">
                        @error('email')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="form-label">{{ __('auth.register.form.password_label') }}</label>
                        <input wire:model="password"
                            type="password"
                            required
                            class="form-field {{ $errors->has('password') ? 'form-field-error' : '' }}">
                        @error('password')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="form-label">{{ __('auth.register.form.password_confirmation_label') }}</label>
                        <input wire:model="password_confirmation"
                            type="password"
                            required
                            class="form-field {{ $errors->has('password_confirmation') ? 'form-field-error' : '' }}">
                        @error('password_confirmation')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms -->
                    <div class="text-small">
                        {{ __('auth.register.terms') }}
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2 sm:pt-3">
                        <button type="submit"
                            wire:loading.attr="disabled"
                            wire:target="register"
                            x-bind:disabled="closing"
                            class="modal-btn-primary">
                            <span wire:loading.remove wire:target="register">{{ __('auth.register.register_button') }}</span>
                            <span wire:loading wire:target="register">{{ __('auth.register.creating') }}</span>
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>