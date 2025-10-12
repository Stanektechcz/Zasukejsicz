<div>
    <!-- Registration Modal -->
    @if($showModal)
    <div x-data="{ 
        show: true,
        init() {
            document.body.style.overflow = 'hidden';
        },
        destroy() {
            document.body.style.overflow = '';
        }
    }"
        x-show="show"
        x-transition.opacity.duration.300ms
        class="fixed inset-0 z-50 flex items-center justify-center p-2"
        wire:ignore.self>

        <!-- Modal Backdrop -->
        <div class="fixed inset-0 backdrop-blur-lg"
            style="background-color: rgba(92, 45, 98, 0.8);"
            @click="$wire.hide()"></div>

        <!-- Modal Content -->
        <div class="relative w-lg bg-white rounded-3xl p-10 py-16 pb-7 shadow-xl">
            <!-- Step Back Button (only on step 2) -->
            @if($currentStep === 2)
            <button wire:click="previousStep"
                class="absolute top-7 left-7 w-7 h-7 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            @endif

            <!-- Close Button -->
            <button @click="$wire.hide()"
                class="absolute top-7 right-7 w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center hover:bg-primary/80 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            @if($currentStep === 1)
            <!-- Step 1: Gender Selection -->
            <div class="text-center">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-secondary mb-1">Registrace</h1>
                </div>

                <!-- Gender Options -->
                <div class="space-y-4 max-w-md mx-auto">
                    <!-- Female Option -->
                    <button wire:click="selectGender('female')"
                        class="w-full p-6 rounded-2xl bg-white shadow-lg transition-all duration-200 hover:shadow-xl {{ $gender === 'female' ? 'border-primary-500' : 'border-gray-200' }}">
                        <div class="flex items-center justify-between">
                            <div class="text-left">
                                <h3 class="text-lg m-0 font-bold text-secondary">Jsem žena</h3>
                                <p class="text-sm text-gray-500">a chci si přivydělat...</p>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-gray-100 rounded-full p-2 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary transform transition-transform {{ $gender === 'female' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </button>

                    <!-- Male Option -->
                    <button wire:click="selectGender('male')"
                        class="w-full p-6 rounded-2xl bg-white shadow-lg transition-all duration-200 hover:shadow-xl {{ $gender === 'male' ? 'border-primary-500' : 'border-gray-200' }}">
                        <div class="flex items-center justify-between">
                            <div class="text-left">
                                <h3 class="text-lg m-0 font-bold text-secondary">Jsem muž</h3>
                                <p class="text-sm text-gray-500">a chci si společnost...</p>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-gray-100 rounded-full p-2 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary transform transition-transform {{ $gender === 'male' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </button>
                </div>

                @error('gender')
                <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @elseif($currentStep === 2)
            <!-- Step 2: Registration Form -->
            <div>
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-secondary mb-1">Registrace</h1>
                    <h2 class="text-4xl font-bold text-primary">
                        @if($gender === 'female')
                            pro ženy
                        @elseif($gender === 'male')
                            pro muže
                        @endif
                    </h2>
                </div>

                <!-- Form -->
                <form wire:submit="register" class="space-y-3 bg-gray-100 p-6 rounded-xl">
                    <!-- Name -->
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Uživatelské jméno</label>
                        <input wire:model="name"
                            type="text"
                            required
                            class="w-full px-3 py-2 !border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Váš email</label>
                        <input wire:model="email"
                            type="email"
                            required
                            class="w-full px-3 py-2 border-2 !border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Heslo</label>
                        <input wire:model="password"
                            type="password"
                            required
                            class="w-full px-3 py-2 border-2 !border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Potvrďte heslo</label>
                        <input wire:model="password_confirmation"
                            type="password"
                            required
                            class="w-full px-3 py-2 border-2 !border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('password_confirmation')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms -->
                    <div class="text-[10px] text-gray-600 px-2">
                        Pokračování a registrací souhlasíte s Oprávněné aniž i odstoupil o snadno osoby vede grafikou osobami úmyslu 60 % poskytovat, dělí způsobem, § 36 veletrhu pověřit spravují zřejmém, k před platbě státu zvláštních tuzemsku. Dohodnou zvláštní provádí.
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3">
                        <button type="submit"
                            wire:loading.attr="disabled"
                            class="w-full bg-primary text-white font-semibold py-4 rounded-lg hover:bg-primary/80 transition-colors disabled:opacity-50">
                            <span wire:loading.remove>Registrovat se ZDARMA</span>
                            <span wire:loading>Vytváření...</span>
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>