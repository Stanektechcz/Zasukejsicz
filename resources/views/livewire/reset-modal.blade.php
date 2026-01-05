<div x-data="{ show: false, closing: false }"
    x-on:show-reset-modal.window="show = true"
    x-on:hide-reset-modal.window="show = false; closing = false"
    x-init="$watch('show', v => document.body.style.overflow = v ? 'hidden' : '')">
    <!-- Reset Password Modal -->
    <div x-show="show"
        x-transition.opacity.duration.300ms
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-2">

        <!-- Modal Backdrop -->
        <div class="fixed inset-0 backdrop-blur-lg"
            style="background-color: rgba(92, 45, 98, 0.8);"
            @click="closing = true; show = false"></div>

        <!-- Modal Content -->
        <div class="relative w-lg bg-white rounded-3xl p-10 py-16 shadow-xl">
            <!-- Close Button -->
            <button @click="closing = true; show = false"
                class="absolute top-7 right-7 w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center hover:bg-primary/80 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            @if(!$emailSent)
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-secondary mb-1">{{ __('auth.reset.subtitle') }}</h1>
                <p class="text-gray-600 mt-4">{{ __('auth.reset.description') }}</p>
            </div>

            <!-- Form -->
            <form wire:submit="sendResetLink" class="space-y-4 bg-gray-100 p-7 rounded-xl">
                <!-- Reset Error -->
                @error('reset')
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                    {{ $message }}
                </div>
                @enderror

                <!-- Email Field -->
                <div>
                    <label class="block text-sm text-gray-600 mb-2">{{ __('auth.reset.email_label') }}</label>
                    <input wire:model="email"
                        type="email"
                        required
                        class="w-full px-4 py-3 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }}">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="sendResetLink"
                    x-bind:disabled="closing"
                    class="w-full bg-primary text-white font-semibold py-4 rounded-lg hover:bg-primary/80 transition-colors disabled:opacity-50">
                    <span wire:loading.remove wire:target="sendResetLink">{{ __('auth.reset.send_button') }}</span>
                    <span wire:loading wire:target="sendResetLink">{{ __('auth.reset.sending') }}</span>
                </button>
            </form>

            @else
            <!-- Success State -->
            <div class="text-center">
                <!-- Success Icon -->
                <div class="mx-auto mb-6 w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Success Message -->
                <h1 class="text-3xl font-bold text-secondary mb-4">{{ __('auth.reset.success_title') }}</h1>
                <p class="text-gray-600 mb-8 text-lg leading-relaxed">{{ __('auth.reset.success_message') }}</p>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button type="button"
                        wire:click="backToLogin"
                        x-bind:disabled="closing"
                        class="w-full bg-primary text-white font-semibold py-4 rounded-lg hover:bg-primary/80 transition-colors disabled:opacity-50">
                        {{ __('auth.reset.back_to_login') }}
                    </button>
                    
                    <button type="button"
                        @click="closing = true; show = false"
                        x-bind:disabled="closing"
                        class="w-full border-[1.5px] border-gray-300 text-gray-600 text-sm font-semibold py-3 rounded-xl hover:bg-gray-50 transition-colors disabled:opacity-50">
                        {{ __('auth.reset.close') }}
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>