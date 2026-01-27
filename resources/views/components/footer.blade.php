<footer x-data class="py-8 md:py-12 pt-12 md:pt-20">
    <div class="container mx-auto px-4">
        <!-- Logo -->
        <div class="text-center mb-6 md:mb-8">
            <h2 class="text-xl md:text-2xl font-extrabold">
                <span class="text-secondary-500">ZAŠUKEJ</span>
                <span class="text-primary-500">SI</span>
                <span class="text-dark-gray">.CZ</span>
            </h2>
        </div>

        <!-- Footer Content -->
        <div class="flex flex-col flex-wrap md:flex-row justify-between items-start gap-6 md:gap-8 mb-6 md:mb-8">
            <!-- Registration Button -->
            @guest
            <div class="flex-shrink-0 w-full md:w-auto">
                <button @click="$dispatch('show-register-modal')" class="btn-primary w-full md:w-auto px-6 md:px-8 py-2.5 md:py-3 rounded-lg font-semibold text-sm md:text-base">
                    {{ __('front.footer.registration') }}
                </button>
            </div>
            @endguest

            <!-- Footer Links -->
            @if(isset($footerPages) && $footerPages->count() > 0)
                @php
                    $chunks = $footerPages->chunk(ceil($footerPages->count() / 3));
                @endphp
                <div class="w-full md:w-auto grid grid-cols-2 md:flex md:flex-row gap-6 md:gap-8">
                    @foreach($chunks as $chunk)
                    <div class="space-y-2 md:space-y-3">
                        @foreach($chunk as $page)
                            <a href="{{ url('/' . $page->slug) }}" class="block text-sm md:text-base text-gray-600 hover:text-primary-500 transition-colors">
                                {{ $page->title }}
                            </a>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            @endif

            <div class="flex-shrink-0 w-full md:max-w-sm">
                <!-- Security Text -->
                <div class="alert !py-2 md:!py-2.5 alert-error">
                    <div class="flex items-center">
                        <x-icons name="lock" class="w-8 md:w-11 mr-2.5 md:mr-3.5 text-primary flex-shrink-0" />
                        <span class="text-xs md:text-sm text-gray-600 leading-tight">{{ __('front.footer.discreet') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Info -->
        <div class="pt-6 md:pt-8 border-t md:border-t-0">
            <!-- Mobile: Stacked Layout -->
            <div class="flex flex-col items-center gap-2 lg:hidden">
                <!-- Security Badge -->
                <div class="flex flex-wrap lg:flex-nowrap items-center justify-center gap-1 font-semibold">
                    <span class="text-green-600 font-semibold text-sm">{{ __('front.footer.ecological') }}</span>
                    <span class="text-gray-500 text-[10px]">{{ __('front.footer.verification') }}</span>
                </div>
                <!-- Copyright -->
                <div class="text-gray-500 text-xs text-center leading-relaxed pt-5 px-4">
                    {{ __('front.footer.copyright') }}
                </div>
            </div>

            <!-- Desktop: Horizontal Layout -->
            <div class="hidden lg:flex justify-between items-center gap-4">
                <div class="flex items-center gap-1 font-semibold">
                    <span class="text-green-600 font-semibold text-sm">{{ __('front.footer.ecological') }}</span>
                    <span class="text-gray-500 text-xs">{{ __('front.footer.verification') }}</span>
                </div>

                <hr class="flex-grow !border-t-2 rounded-full">

                <div class="text-gray-500 text-sm">
                    {{ __('front.footer.copyright') }}
                </div>
            </div>
        </div>
    </div>
</footer>