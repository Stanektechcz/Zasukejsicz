<div x-data="{ show: false, closing: false }"
    x-on:show-reset-modal.window="show = true; $wire.show()"
    x-on:hide-reset-modal.window="show = false; closing = false"
    x-init="$watch('show', v => document.body.style.overflow = v ? 'hidden' : '')"
    x-on:keydown.escape.window="if (show) { closing = true; show = false; $wire.hide() }">
    <!-- Reset Password Modal -->
    <div x-show="show"
        x-transition.opacity.duration.300ms
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4">

        <!-- Modal Backdrop -->
        <div class="modal-backdrop"
            @click="closing = true; show = false; $wire.hide()"></div>

        <!-- Modal Content -->
        <div class="modal-container">
            <!-- Close Button -->
            <button @click="closing = true; show = false; $wire.hide()"
                class="modal-close-btn">
                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            @if(!$emailSent)
            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title">{{ __('auth.reset.subtitle') }}</h1>
                <p class="modal-description">{{ __('auth.reset.description') }}</p>
            </div>

            <!-- Form -->
            <form wire:submit="sendResetLink" class="form-container">
                <!-- Reset Error -->
                @error('reset')
                <div class="form-alert">
                    {{ $message }}
                </div>
                @enderror

                <!-- Email Field -->
                <div>
                    <label class="form-label">{{ __('auth.reset.email_label') }}</label>
                    <input wire:model="email"
                        type="email"
                        required
                        class="form-field {{ $errors->has('email') ? 'form-field-error' : '' }}">
                    @error('email')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="sendResetLink"
                    x-bind:disabled="closing"
                    class="modal-btn-primary">
                    <span wire:loading.remove wire:target="sendResetLink">{{ __('auth.reset.send_button') }}</span>
                    <span wire:loading wire:target="sendResetLink">{{ __('auth.reset.sending') }}</span>
                </button>
            </form>

            @else
            <!-- Success State -->
            <div class="text-center">
                <!-- Success Icon -->
                <div class="modal-success-icon">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Success Message -->
                <h1 class="text-2xl sm:text-3xl font-bold text-secondary mb-3 sm:mb-4">{{ __('auth.reset.success_title') }}</h1>
                <p class="text-gray-600 mb-6 sm:mb-8 text-sm sm:text-base md:text-lg leading-relaxed">{{ __('auth.reset.success_message') }}</p>

                <!-- Action Buttons -->
                <div class="space-y-2.5 sm:space-y-3">
                    <button type="button"
                        wire:click="backToLogin"
                        x-bind:disabled="closing"
                        class="modal-btn-primary">
                        {{ __('auth.reset.back_to_login') }}
                    </button>
                    
                    <button type="button"
                        @click="closing = true; show = false; $wire.hide()"
                        x-bind:disabled="closing"
                        class="modal-btn-secondary">
                        {{ __('auth.reset.close') }}
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>