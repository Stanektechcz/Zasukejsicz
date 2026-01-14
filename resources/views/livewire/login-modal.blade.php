<div x-data="{ show: false, closing: false }"
    x-on:show-login-modal.window="console.log('Login modal event received'); show = true"
    x-on:hide-login-modal.window="show = false; closing = false"
    x-init="console.log('Login modal Alpine initialized'); $watch('show', v => document.body.style.overflow = v ? 'hidden' : '')">
    <!-- Login Modal -->
    <div x-show="show"
        x-transition.opacity.duration.300ms
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4">

        <!-- Modal Backdrop -->
        <div class="modal-backdrop"
            @click="closing = true; show = false"></div>

        <!-- Modal Content -->
        <div class="modal-container">
            <!-- Close Button -->
            <button @click="closing = true; show = false"
                class="modal-close-btn">
                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title">{{ __('auth.login.title') }}</h1>
                <h2 class="modal-subtitle">{{ __('auth.login.subtitle') }}</h2>
            </div>

            <!-- Form -->
            <form wire:submit="authenticate" class="form-container">
                <!-- Login Error -->
                @error('login')
                <div class="form-alert">
                    {{ $message }}
                </div>
                @enderror
                <!-- Username Field -->
                <div>
                    <label class="form-label">{{ __('auth.login.email_label') }}</label>
                    <input wire:model="email"
                        type="email"
                        required
                        class="form-field {{ $errors->has('email') ? 'form-field-error' : '' }}">
                    @error('email')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label class="form-label">{{ __('auth.login.password_label') }}</label>
                    <input wire:model="password"
                        type="password"
                        required
                        class="form-field {{ $errors->has('password') ? 'form-field-error' : '' }}">
                    @error('password')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Forgot Password -->
                <div class="text-left">
                    <button type="button" 
                        @click="show = false; $dispatch('show-reset-modal')"
                        class="text-xs sm:text-sm text-gray-500 hover:text-gray-700">{{ __('auth.login.forgot_password') }}</button>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="authenticate"
                    x-bind:disabled="closing"
                    class="modal-btn-primary">
                    <span wire:loading.remove wire:target="authenticate">{{ __('auth.login.login_button') }}</span>
                    <span wire:loading wire:target="authenticate">{{ __('auth.login.logging_in') }}</span>
                </button>
            </form>

            <!-- Register Section -->
            <div class="mt-6 sm:mt-8 text-center px-4 sm:px-6">
                <p class="text-base sm:text-lg font-semibold text-secondary mb-3 sm:mb-4">{{ __('auth.unknown_text') }}</p>
                <button type="button"
                    @click="show = false; $dispatch('show-register-modal')"
                    x-bind:disabled="closing"
                    class="modal-btn-outline">
                    {{ __('auth.switch_to_register') }}
                </button>
            </div>
        </div>
    </div>
</div>