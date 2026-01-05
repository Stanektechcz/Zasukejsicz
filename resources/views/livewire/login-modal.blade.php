<div x-data="{ show: false, closing: false }"
    x-on:show-login-modal.window="console.log('Login modal event received'); show = true"
    x-on:hide-login-modal.window="show = false; closing = false"
    x-init="console.log('Login modal Alpine initialized'); $watch('show', v => document.body.style.overflow = v ? 'hidden' : '')">
    <!-- Login Modal -->
    <div x-show="show"
        x-transition.opacity.duration.300ms
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-2">

        <!-- Modal Backdrop -->
        <div class="fixed inset-0 backdrop-blur-lg"
            style="background-color: rgba(92, 45, 98, 0.8);"
            @click="closing = true; show = false"></div>

        <!-- Modal Content -->
        <div class="relative w-lg bg-white rounded-3xl p-10 py-16 shadow-xl ">
            <!-- Close Button -->
            <button @click="closing = true; show = false"
                class="absolute top-7 right-7 w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center hover:bg-primary/80 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-secondary mb-1">{{ __('auth.login.title') }}</h1>
                <h2 class="text-3xl font-bold text-primary">{{ __('auth.login.subtitle') }}</h2>
            </div>

            <!-- Form -->
            <form wire:submit="authenticate" class="space-y-4 bg-gray-100 p-7 rounded-xl">
                <!-- Login Error -->
                @error('login')
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                    {{ $message }}
                </div>
                @enderror
                <!-- Username Field -->
                <div>
                    <label class="block text-sm text-gray-600 mb-2">{{ __('auth.login.email_label') }}</label>
                    <input wire:model="email"
                        type="email"
                        required
                        class="w-full px-4 py-3 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }}">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-sm text-gray-600 mb-2">{{ __('auth.login.password_label') }}</label>
                    <input wire:model="password"
                        type="password"
                        required
                        class="w-full px-4 py-3 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }}">
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Forgot Password -->
                <div class="text-left">
                    <button type="button" 
                        @click="show = false; $dispatch('show-reset-modal')"
                        class="text-sm text-gray-500 hover:text-gray-700">{{ __('auth.login.forgot_password') }}</button>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="authenticate"
                    x-bind:disabled="closing"
                    class="w-full bg-primary text-white font-semibold py-4 rounded-lg hover:bg-primary/80 transition-colors disabled:opacity-50">
                    <span wire:loading.remove wire:target="authenticate">{{ __('auth.login.login_button') }}</span>
                    <span wire:loading wire:target="authenticate">{{ __('auth.login.logging_in') }}</span>
                </button>
            </form>

            <!-- Register Section -->
            <div class="mt-8 text-center px-6">
                <p class="text-lg font-semibold text-secondary mb-4">{{ __('auth.unknown_text') }}</p>
                <button type="button"
                    @click="show = false; $dispatch('show-register-modal')"
                    x-bind:disabled="closing"
                    class="w-full border-[1.5px] border-primary text-primary text-sm font-semibold py-3 rounded-xl hover:bg-primary/10 transition-colors disabled:opacity-50">
                    {{ __('auth.switch_to_register') }}
                </button>
            </div>
        </div>
    </div>
</div>