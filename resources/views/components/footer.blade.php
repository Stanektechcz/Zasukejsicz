<footer x-data class="py-12 pt-20">
    <div class="container mx-auto px-4">
        <!-- Logo -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold">
                <span class="text-secondary-500">ZAŠUKEJ</span>
                <span class="text-primary-500">SI</span>
                <span class="text-dark-gray">.CZ</span>
            </h2>
        </div>

        <!-- Footer Content -->
        <div class="flex flex-col flex-wrap md:flex-row justify-between items-start gap-8 mb-8">
            <!-- Registration Button -->
            @guest
            <div class="flex-shrink-0">
                <button @click="$dispatch('show-register-modal')" class="btn-primary w-full md:w-auto px-8 py-3 rounded-lg font-semibold">
                    {{ __('front.footer.registration') }}
                </button>
            </div>
            @endguest

            <!-- Footer Links -->
            @if(isset($footerPages) && $footerPages->count() > 0)
                @php
                    $chunks = $footerPages->chunk(ceil($footerPages->count() / 3));
                @endphp
                @foreach($chunks as $chunk)
                <div class="space-y-3">
                    @foreach($chunk as $page)
                        <a href="{{ url('/' . $page->slug) }}" class="block text-gray-600 hover:text-primary-500 transition-colors">
                            {{ $page->title }}
                        </a>
                    @endforeach
                </div>
                @endforeach
            @endif

            <div class="flex-shrink-0 max-w-sm">
                <!-- Security Text -->
                <div class="alert !py-2.5 alert-error">
                    <div class="flex items-center">
                        <x-icons name="lock" class="w-11 mr-3.5 text-primary" />
                        <span class="text-sm text-gray-600">{{ __('front.footer.discreet') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Info -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 pt-8">
            <!-- Security Badge -->
            <div class="flex items-center gap-1 font-semibold">
                <span class="text-green-600 font-semibold text-sm">{{ __('front.footer.ecological') }}</span>
                <span class="text-gray-500 text-xs">{{ __('front.footer.verification') }}</span>
            </div>

            <hr class="flex-grow !border-t-2 rounded-full">

            <!-- Copyright -->
            <div class="text-gray-500 text-sm">
                {{ __('front.footer.copyright') }}
            </div>
        </div>
    </div>
</footer>