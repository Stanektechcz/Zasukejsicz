{{-- Advert Hero Component --}}
<section class="advert-hero relative overflow-hidden rounded-3xl">
    {{-- Background Image with Light Overlay --}}
    <div class="absolute inset-0">
        <img 
            src="{{ asset('images/advert.png') }}" 
            alt="Advert background" 
            class="w-full h-full object-cover blur-xs"
        >
        <div class="absolute inset-0 bg-white/30"></div>
    </div>

    {{-- Content Container --}}
    <div class="relative z-10 px-8 py-12 md:px-14 md:py-16 lg:px-36 lg:py-40">
        {{-- Text Content --}}
        <div class="max-w-2xl mb-8 md:mb-7 relative">
            <x-icons name="quote" :fill="true" class="absolute -left-14 -top-6 w-10 h-10 text-primary" />
            <h2 class="advert-hero-title text-secondary mb-3">
                Vydělávej, dokud jsi mladá...
            </h2>
            <p class="advert-hero-subtitle text-gray-600 text-base md:text-lg leading-relaxed max-w-lg">
                Čekají gentlemani, kteří čas a péči, kterou věnuješ svému tělu, náležitě ocení!
            </p>
        </div>

        {{-- CTA Button --}}
        <div class="mb-10 md:mb-10">
            <a href="#" class="btn-primary !py-3 inline-flex items-center gap-3 min-w-[304px]">
                Založit účet
                <x-icons name="heart" class="w-5 h-5" />
            </a>
        </div>

        {{-- Feature Blocks --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            {{-- Feature 1 --}}
            <div class="feature-block">
                <div class="feature-block-icon">
                    <x-icons name="hand-heart" :strokeWidth="2.5" class="w-8 h-8 text-primary" />
                </div>
                <p class="feature-block-text">
                    Oprávněné aniž i osoby vede grafikou osobami úmyslu 60 %
                </p>
            </div>

            {{-- Feature 2 --}}
            <div class="feature-block">
                <div class="feature-block-icon">
                    <x-icons name="icecream" :strokeWidth="2.5" class="w-8 h-8 text-primary" />
                </div>
                <p class="feature-block-text">
                    Oprávněné aniž i o snadno osoby grafikou osobami úmyslu 60 %
                </p>
            </div>

            {{-- Feature 3 --}}
            <div class="feature-block">
                <div class="feature-block-icon">
                    <x-icons name="laptop" :strokeWidth="2.5" class="w-9 h-9 text-primary" />
                </div>
                <p class="feature-block-text">
                    Oprávněné aniž i o snadno osoby osobami úmyslu 60 %
                </p>
            </div>
        </div>
    </div>
</section> 