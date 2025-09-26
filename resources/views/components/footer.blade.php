<footer class="py-12 pt-20">
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
            <div class="flex-shrink-0">
                <button class="btn-primary w-full md:w-auto px-8 py-3 rounded-lg font-semibold">
                    {{ __('front.footer.registration') }}
                </button>
            </div>

            <!-- Links Column 1 -->
            <div class="space-y-3">
                <a href="#" class="block text-gray-600 hover:text-primary-500 transition-colors">{{ __('front.footer.faq') }}</a>
                <a href="#" class="block text-gray-600 hover:text-primary-500 transition-colors">{{ __('front.footer.contact') }}</a>
            </div>

            <!-- Links Column 2 -->
            <div class="space-y-3">
                <a href="#" class="block text-gray-600 hover:text-primary-500 transition-colors">{{ __('front.footer.privacy') }}</a>
                <a href="#" class="block text-gray-600 hover:text-primary-500 transition-colors">{{ __('front.footer.ethics') }}</a>
            </div>

            <!-- Links Column 3 -->
            <div class="space-y-3">
                <a href="#" class="block text-gray-600 hover:text-primary-500 transition-colors">{{ __('front.footer.vipgirls') }}</a>
                <a href="#" class="block text-gray-600 hover:text-primary-500 transition-colors">{{ __('front.footer.premiummale') }}</a>
            </div>

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