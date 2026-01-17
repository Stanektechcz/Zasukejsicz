@props(['profile'])

<div class="max-w-7xl mx-auto px-4 py-8 pt-30">
    <!-- Top Action Bar -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <!-- VIP Profile Badge -->
            @if($profile->isVip())
            <div class="bg-gold-500 text-white px-3 py-1 rounded-lg text-sm font-bold flex items-center gap-2">
                <x-icons name="star" class="w-4 h-4" />
                {{ __('front.profiles.detail_page.vip') }}
            </div>
            @endif

            <!-- Unverified Photo Badge -->
            @if(!$profile->isVerified())
            <div class="bg-gray-400 text-white px-3 py-1 rounded-lg text-sm font-medium flex items-center gap-2">
                <x-icons name="camera" class="w-4 h-4" />
                {{ __('front.profiles.detail_page.photos_unverified') }}
            </div>
            @else
            <div class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm font-medium flex items-center gap-2">
                <x-icons name="camera" class="w-4 h-4" />
                {{ __('front.profiles.list.verified') }}
            </div>
            @endif
        </div>

        <!-- Top Right Actions -->
        <div class="flex items-center gap-3">
            <!-- Rating Badge -->
            <!-- <div class="flex items-center text-pink-500 text-sm font-medium">
                <span>{{ __('front.profiles.detail_page.give_rating') }}</span>
            </div> -->

            <!-- Refresh Access Button -->
            <!-- <button class="flex items-center gap-2 text-pink-500 text-sm font-medium hover:text-pink-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                {{ __('front.profiles.detail_page.refresh_access') }}
            </button> -->

            <!-- Report Profile -->
            <!-- <button class="flex items-center gap-2 text-red-500 text-sm font-medium hover:text-red-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.866-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                {{ __('front.profiles.detail_page.report_profile') }}
            </button> -->
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Sidebar - Profile Info -->
        <div class="lg:col-span-1">
            <div class="p-6">
                <!-- Profile Header -->
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-bold text-secondary mb-2">{{ $profile->display_name ?? 'Alexandrina' }}</h1>

                    <!-- Rating Section -->
                    <div class="mb-4">
                        @livewire('profile-rating', ['profile' => $profile])
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="space-y-4">
                    <!-- Location -->
                    <div class="flex items-center justify-center text-pink-500">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $profile->city ?? 'Jihomoravský kraj' }}</span>
                    </div>

                    <!-- Profile Stats -->
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-pink-500 font-medium">{{ __('front.profiles.detail_page.age') }}</span>
                            <span class="text-gray-900">{{ $profile->age ?? '19' }} {{ __('front.profiles.detail_page.years') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-pink-500 font-medium">{{ __('front.profiles.detail_page.weight') }}</span>
                            <span class="text-gray-900">{{ $profile->weight ?? '57' }} {{ __('front.profiles.detail_page.kg') }} / {{ $profile->weight_lbs ?? '126' }} {{ __('front.profiles.detail_page.lbs') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-pink-500 font-medium">{{ __('front.profiles.detail_page.height') }}</span>
                            <span class="text-gray-900">{{ $profile->height ?? '168' }} {{ __('front.profiles.detail_page.cm') }} / {{ $profile->height_feet ?? "5'9\"" }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-pink-500 font-medium">{{ __('front.profiles.detail_page.bust') }}</span>
                            <span class="text-gray-900">{{ $profile->bust_size ?? 'C' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-pink-500 font-medium">{{ __('front.profiles.detail_page.languages') }}</span>
                            <span class="text-gray-900 text-right">{{ $profile->languages ?? 'Česky, Rusky, Anglicky' }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3 pt-4">
                        <!-- Call Buttons -->
                        <div class="grid grid-cols-2 gap-3">
                            <button class="{{ $profile->incall ? 'btn-light-green' : 'btn-transparent' }} flex items-center justify-center gap-2">
                                <span class="w-7 h-7 {{ $profile->incall ? 'bg-green-600' : 'bg-red-600' }} rounded-full flex items-center justify-center">
                                    @if($profile->incall)
                                        <svg class="w-4 h-4 text-white fill-current translate-y-px" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" d="M16.707 5.293l-8 8-4-4" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-white fill-current" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" d="M4.293 4.293l11.414 11.414M15.707 4.293L4.293 15.707" />
                                        </svg>
                                    @endif
                                </span>
                                {{ __('front.profiles.detail_page.incall') }}
                            </button>
                            <button class="{{ $profile->outcall ? 'btn-light-green' : 'btn-transparent' }} flex items-center justify-center gap-2">
                                <span class="w-7 h-7 {{ $profile->outcall ? 'bg-green-600' : 'bg-red-600' }} rounded-full flex items-center justify-center">
                                    @if($profile->outcall)
                                        <svg class="w-4 h-4 text-white fill-current translate-y-px" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" d="M16.707 5.293l-8 8-4-4" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-white fill-current" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" d="M4.293 4.293l11.414 11.414M15.707 4.293L4.293 15.707" />
                                        </svg>
                                    @endif
                                </span>
                                {{ __('front.profiles.detail_page.outcall') }}
                            </button>
                        </div>

                        <!-- Send Message Button -->
                        @auth
                            @if($profile->user_id && $profile->user_id !== Auth::id())
                                <a href="{{ route('messages.show', $profile->user) }}" class="btn-primary w-full flex items-center justify-center gap-2">
                                    {{ __('front.profiles.detail_page.send_message') }}
                                    <x-icons name="message" class="w-5 h-5" />
                                </a>
                            @else
                                <button class="btn-primary w-full opacity-50 cursor-not-allowed" disabled>
                                    {{ __('front.profiles.detail_page.send_message') }}
                                </button>
                            @endif
                        @else
                            <button onclick="alert('{{ __('Please login to send messages') }}')" class="btn-primary w-full">
                                {{ __('front.profiles.detail_page.send_message') }}
                            </button>
                        @endauth

                        <!-- Favorite Button - Only for logged in male users -->
                        @auth
                            @if(Auth::user()->isMale())
                                @livewire('favorite-button', ['profile' => $profile])
                            @endif
                        @endauth

                        <!-- Contact Info -->
                        @if($profile->contacts && count($profile->contacts) > 0)
                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            @foreach($profile->contacts as $contact)
                                @if($contact['type'] === 'whatsapp')
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact['value']) }}" 
                                       target="_blank"
                                       class="bg-green-500 text-white p-3 rounded-full hover:bg-green-600 transition-colors"
                                       title="WhatsApp: {{ $contact['value'] }}">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                        </svg>
                                    </a>
                                @elseif($contact['type'] === 'telegram')
                                    <a href="https://t.me/{{ ltrim($contact['value'], '@') }}" 
                                       target="_blank"
                                       class="bg-blue-500 text-white p-3 rounded-full hover:bg-blue-600 transition-colors"
                                       title="Telegram: {{ $contact['value'] }}">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                                        </svg>
                                    </a>
                                @elseif($contact['type'] === 'phone')
                                    <a href="tel:{{ $contact['value'] }}" 
                                       class="flex items-center gap-2 text-gray-700 font-medium hover:text-primary transition-colors"
                                       title="{{ __('front.profiles.detail_page.call') }}">
                                        <span class="bg-gray-200 text-gray-700 p-3 rounded-full">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </span>
                                        <span>{{ $contact['value'] }}</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Photo Gallery and Content -->
        <div class="lg:col-span-2">
            <div class="p-6">
                <!-- Photo Gallery -->
                @if($profile->getAllImages()->count() > 0)
                <div class="mb-6">
                    @if($profile->hasMultipleImages())
                    <!-- Swiper gallery for main images -->
                    <div class="relative bg-gradient-to-br ">
                        <div class="swiper profile-detail-swiper w-full h-96 rounded-xl">
                            <div class="swiper-wrapper">
                                @foreach($profile->getAllImages() as $index => $image)
                                <div class="swiper-slide">
                                    <img src="{{ $image->getUrl() }}" alt="{{ $profile->display_name }}"
                                        class="w-full h-full object-cover cursor-pointer lightbox-trigger"
                                        data-index="{{ $index }}">
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Custom Navigation buttons -->
                        <div class="swiper-button-next-custom absolute top-1/2 -right-5 transform -translate-y-1/2 z-10 cursor-pointer">
                            <div class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center hover:shadow-lg transition-all duration-200">
                                ⏵
                            </div>
                        </div>
                        <div class="swiper-button-prev-custom absolute top-1/2 -left-5 transform -translate-y-1/2 z-10 cursor-pointer">
                            <div class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center  hover:shadow-lg transition-all duration-200">
                                ⏴
                            </div>
                        </div>

                    </div>
                    @else
                    <!-- Single image display if only one image -->
                    <div class="h-96 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-lg overflow-hidden">
                        <img src="{{ $profile->getFirstImageUrl() }}" alt="{{ $profile->display_name }}"
                            class="w-full h-full object-cover cursor-pointer lightbox-trigger"
                            data-index="0">
                    </div>
                    @endif
                </div>
                @else
                <!-- No images placeholder -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="aspect-[3/4] bg-gradient-to-br from-primary-100 to-secondary-100 rounded-lg overflow-hidden flex items-center justify-center">
                        <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="aspect-[3/4] bg-gradient-to-br from-primary-100 to-secondary-100 rounded-lg overflow-hidden flex items-center justify-center">
                        <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                @endif

                <!-- About Section -->
                <div>
                    <h2 class="text-xl font-bold text-secondary mb-4">{{ __('front.profiles.detail_page.about_me') }}</h2>
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-700 leading-relaxed">
                            {{ $profile->about ?? 'No description available.' }}
                        </p>
                    </div>
                </div>

                <!-- Prices Section -->
                

                @if(!empty($profile->local_prices) && is_array($profile->local_prices) && count($profile->local_prices) > 0)
                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-secondary mb-4">{{ __('front.profiles.detail_page.my_prices') }}</h2>
                    
                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Prices Table -->
                        <div class="flex-1 overflow-hidden">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="w-1/4 px-1 py-3 text-left text-sm font-semibold text-gray-700">
                                            <div class="text-center text-gray-700 bg-gray-100 rounded-lg py-3 px-4">
                                                {{ __('front.profiles.detail_page.time') }}
                                            </div>
                                        </th>
                                        <th class="px-1 py-3 text-center text-sm font-semibold">
                                            <div class="flex items-center justify-center gap-2 {{ $profile->incall ? 'text-pink-500' : 'text-gray-400' }} bg-gray-100 rounded-lg py-3">
                                                <span class="w-5 h-5 {{ $profile->incall ? 'bg-green-500' : 'bg-red-500' }} rounded-full flex items-center justify-center text-white">
                                                    @if($profile->incall)
                                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                            <path stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" d="M16.707 5.293l-8 8-4-4" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                            <path stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" d="M4.293 4.293l11.414 11.414M15.707 4.293L4.293 15.707" />
                                                        </svg>
                                                    @endif
                                                </span>
                                                {{ __('front.profiles.detail_page.incall') }}
                                            </div>
                                        </th>
                                        <th class="px-1 py-3 text-center text-sm font-semibold">
                                            <div class="flex items-center justify-center gap-2 {{ $profile->outcall ? 'text-pink-500' : 'text-gray-400' }} bg-gray-100 rounded-lg py-3">
                                                <span class="w-5 h-5 {{ $profile->outcall ? 'bg-green-500' : 'bg-red-500' }} rounded-full flex items-center justify-center text-white">
                                                    @if($profile->outcall)
                                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                            <path stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" d="M16.707 5.293l-8 8-4-4" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                            <path stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" d="M4.293 4.293l11.414 11.414M15.707 4.293L4.293 15.707" />
                                                        </svg>
                                                    @endif
                                                </span>
                                                {{ __('front.profiles.detail_page.outcall') }}
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($profile->local_prices as $price)
                                    <tr class="border-b border-gray-200">
                                        <td class="px-4 py-4 text-pink-500 font-semibold">
                                            {{ $price['time_hours'] ?? '' }} h
                                        </td>
                                        <td class="px-4 py-4 text-center text-gray-900 font-medium">
                                            @if(!empty($price['incall_price']) && $profile->incall)
                                                {{ number_format($price['incall_price'], 0, ',', ' ') }} Kč
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-center text-gray-900 font-medium">
                                            @if(!empty($price['outcall_price']) && $profile->outcall)
                                                {{ number_format($price['outcall_price'], 0, ',', ' ') }} Kč
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Profile Video -->
                        @if($profile->hasVideo())
                        <div class="lg:w-48 shrink-0">
                            <div class="relative w-full aspect-[9/16] bg-black rounded-2xl overflow-hidden shadow-lg">
                                <video 
                                    id="profile-detail-video"
                                    src="{{ $profile->getVideoUrl() }}" 
                                    class="w-full h-full object-cover"
                                    preload="metadata"
                                    playsinline>
                                </video>
                                <!-- Custom Play Button Overlay -->
                                <button 
                                    type="button"
                                    onclick="toggleProfileVideo()"
                                    id="profile-video-play-btn"
                                    class="absolute inset-0 flex items-center justify-center bg-black/30 hover:bg-black/40 transition-all duration-200 cursor-pointer">
                                    <div class="w-14 h-14 bg-primary rounded-full flex items-center justify-center shadow-lg hover:bg-primary-600 hover:scale-110 transition-all duration-200">
                                        <svg id="play-icon" class="w-7 h-7 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                        <svg id="pause-icon" class="w-7 h-7 text-white hidden" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <p class="text-center text-sm text-gray-500 mt-2">{{ __('front.profiles.detail_page.intro_video') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @elseif($profile->hasVideo())
                <!-- Only Video, No Prices -->
                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-secondary mb-4">{{ __('front.profiles.detail_page.intro_video') }}</h2>
                    <div class="w-64 mx-auto">
                        <div class="relative w-full aspect-[9/16] bg-black rounded-2xl overflow-hidden shadow-lg">
                            <video 
                                id="profile-detail-video"
                                src="{{ $profile->getVideoUrl() }}" 
                                class="w-full h-full object-cover"
                                preload="metadata"
                                playsinline>
                            </video>
                            <!-- Custom Play Button Overlay -->
                            <button 
                                type="button"
                                onclick="toggleProfileVideo()"
                                id="profile-video-play-btn"
                                class="absolute inset-0 flex items-center justify-center bg-black/30 hover:bg-black/40 transition-all duration-200 cursor-pointer">
                                <div class="w-14 h-14 bg-primary rounded-full flex items-center justify-center shadow-lg hover:bg-primary-600 hover:scale-110 transition-all duration-200">
                                    <svg id="play-icon" class="w-7 h-7 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                    <svg id="pause-icon" class="w-7 h-7 text-white hidden" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z" />
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Services Section -->
                @if($profile->services && $profile->services->count() > 0)
                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-secondary mb-4">{{ __('front.profiles.detail_page.services') }}</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($profile->services as $service)
                        <span class="px-4 py-2 border-2 border-gray-200 rounded-full text-sm text-gray-700">
                            {{ $service->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
@if($profile->getAllImages()->count() > 0)
<div id="lightbox-modal" class="fixed inset-0 z-50 backdrop-blur-lg hidden items-center justify-center" style="background-color: rgba(255, 255, 255, 0.7);">
    <div class="relative w-full h-full flex items-center justify-center p-4">
        <!-- Close Button -->
        <button id="lightbox-close" class="absolute top-12 right-12 z-60 cursor-pointer">
            <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center hover:shadow-lg transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </button>


        <!-- Lightbox Swiper -->
        <div class="swiper lightbox-swiper w-full h-full flex items-center justify-center">
            <div class="swiper-wrapper">
                @foreach($profile->getAllImages() as $index => $image)
                <div class="swiper-slide !flex items-center justify-center w-full h-full">
                    <img src="{{ $image->getUrl() }}"
                        alt="{{ $profile->display_name }}"
                        class="max-w-[90vw] max-h-[90vh] rounded-2xl object-contain mx-auto"
                        data-index="{{ $index }}">
                </div>
                @endforeach
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="lightbox-button-prev absolute left-16 top-1/2 transform -translate-y-1/2 z-60 cursor-pointer">
            <div class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center hover:shadow-lg transition-all duration-200">
                ⏴
            </div>
        </div>

        <div class="lightbox-button-next absolute right-16 top-1/2 transform -translate-y-1/2 z-60 cursor-pointer">
            <div class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center hover:shadow-lg transition-all duration-200">
                ⏵
            </div>
        </div>

        <!-- Thumbnail Navigation -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-60 w-full max-w-md px-4">
            <div class="swiper lightbox-thumbs-swiper">
                <div class="swiper-wrapper">
                    @foreach($profile->getAllImages() as $index => $image)
                    <div class="swiper-slide">
                        <div class="lightbox-thumb w-16 h-18 rounded-lg overflow-hidden cursor-pointer border-2 border-transparent hover:border-white transition-all duration-200" data-index="{{ $index }}">
                            <img src="{{ $image->getUrl() }}"
                                alt="{{ $profile->display_name }}"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if Swiper is available
        if (typeof Swiper === 'undefined') {
            console.error('Swiper is not loaded. Make sure to build assets with npm run build');
            return;
        }

        // Initialize Swiper for profile detail
        const profileDetailSwiper = new Swiper('.profile-detail-swiper', {
            loop: true,
            slidesPerView: 3,
            spaceBetween: 16,
            centeredSlides: true,

            // Responsive breakpoints
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 12
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 16
                }
            },

            navigation: {
                nextEl: '.swiper-button-next-custom',
                prevEl: '.swiper-button-prev-custom',
            },

            preloadImages: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
        });

        // Initialize Lightbox Swiper
        let lightboxSwiper = null;
        let lightboxThumbsSwiper = null;
        const lightboxModal = document.getElementById('lightbox-modal');
        const lightboxClose = document.getElementById('lightbox-close');

        function initializeLightboxSwiper() {
            if (!lightboxSwiper && lightboxModal) {
                // Initialize thumbnails swiper first
                lightboxThumbsSwiper = new Swiper('.lightbox-thumbs-swiper', {
                    spaceBetween: 0,
                    slidesPerView: 5,
                    centeredSlides: true,
                    watchSlidesProgress: true,
                    slideToClickedSlide: true,
                });

                // Initialize main lightbox swiper
                lightboxSwiper = new Swiper('.lightbox-swiper', {
                    loop: true,
                    slidesPerView: 1,
                    spaceBetween: 0,
                    centeredSlides: true,
                    initialSlide: 0, // Always start at first slide, we'll manually navigate
                    
                    navigation: {
                        nextEl: '.lightbox-button-next',
                        prevEl: '.lightbox-button-prev',
                    },

                    keyboard: {
                        enabled: true,
                    },

                    thumbs: {
                        swiper: lightboxThumbsSwiper,
                    },

                    on: {
                        slideChange: function() {
                            console.log('Slide changed to realIndex:', this.realIndex); // Debug log
                            updateThumbActiveState(this.realIndex);
                        },
                        init: function() {
                            console.log('Swiper initialized with realIndex:', this.realIndex); // Debug log
                            updateThumbActiveState(this.realIndex || 0);
                        }
                    }
                });                // Add click handlers for thumbnails
                document.querySelectorAll('.lightbox-thumb').forEach(function(thumb, index) {
                    thumb.addEventListener('click', function() {
                        const targetIndex = parseInt(this.dataset.index);
                        if (lightboxSwiper) {
                            lightboxSwiper.slideTo(targetIndex + 1, 300); // +1 for loop mode
                        }
                    });
                });
            }
        }

        function updateThumbActiveState(activeIndex) {
            document.querySelectorAll('.lightbox-thumb').forEach(function(thumb, index) {
                if (index === activeIndex) {
                    thumb.classList.add('border-white', 'opacity-100');
                    thumb.classList.remove('border-transparent', 'opacity-60');
                } else {
                    thumb.classList.add('border-transparent', 'opacity-60');
                    thumb.classList.remove('border-white', 'opacity-100');
                }
            });
        }

        // Open lightbox when image is clicked
        document.querySelectorAll('.lightbox-trigger').forEach(function(trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Get the clicked image index
                const targetIndex = parseInt(this.dataset.index);
                console.log('Clicked image index:', targetIndex); // Debug log
                
                if (lightboxModal) {
                    // Show modal first
                    lightboxModal.classList.remove('hidden');
                    lightboxModal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                    
                    // Initialize swiper after modal is shown with longer delay
                    setTimeout(() => {
                        initializeLightboxSwiper();
                        
                        if (lightboxSwiper) {
                            // Force update and then go to target slide
                            lightboxSwiper.update();
                            
                            // For loop mode, we need to account for cloned slides
                            const slideToIndex = targetIndex + 1; // +1 for loop mode
                            console.log('Going to slide:', slideToIndex); // Debug log
                            
                            lightboxSwiper.slideTo(slideToIndex, 0);
                            
                            // Update thumbnail active state
                            updateThumbActiveState(targetIndex);
                        }
                    }, 100); // Increased delay to ensure proper initialization
                }
            });
        });        // Close lightbox function
        function closeLightbox() {
            if (lightboxModal) {
                lightboxModal.classList.add('hidden');
                lightboxModal.classList.remove('flex');
                document.body.style.overflow = '';

                // Destroy swiper instances to prevent memory leaks
                if (lightboxSwiper) {
                    lightboxSwiper.destroy(true, true);
                    lightboxSwiper = null;
                }
                if (lightboxThumbsSwiper) {
                    lightboxThumbsSwiper.destroy(true, true);
                    lightboxThumbsSwiper = null;
                }
            }
        }

        // Close lightbox on close button click
        if (lightboxClose) {
            lightboxClose.addEventListener('click', closeLightbox);
        }

        // Close lightbox on background click
        if (lightboxModal) {
            lightboxModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeLightbox();
                }
            });
        }

        // Close lightbox on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && lightboxModal && !lightboxModal.classList.contains('hidden')) {
                closeLightbox();
            }
        });

        // Add click event for thumbnails to change the main swiper slide
        document.querySelectorAll('.image-thumbnail').forEach(function(thumbnail) {
            thumbnail.addEventListener('click', function() {
                const slideIndex = parseInt(this.dataset.index);
                if (profileDetailSwiper) {
                    profileDetailSwiper.slideTo(slideIndex + 1); // +1 because of loop mode
                }
            });
        });
    });

    // Profile Video Playback Control
    function toggleProfileVideo() {
        const video = document.getElementById('profile-detail-video');
        const playBtn = document.getElementById('profile-video-play-btn');
        const playIcon = document.getElementById('play-icon');
        const pauseIcon = document.getElementById('pause-icon');
        
        if (!video) return;
        
        if (video.paused) {
            video.play();
            if (playBtn) playBtn.style.opacity = '0';
            if (playIcon) playIcon.classList.add('hidden');
            if (pauseIcon) pauseIcon.classList.remove('hidden');
        } else {
            video.pause();
            if (playBtn) playBtn.style.opacity = '1';
            if (playIcon) playIcon.classList.remove('hidden');
            if (pauseIcon) pauseIcon.classList.add('hidden');
        }
    }

    // Video event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const video = document.getElementById('profile-detail-video');
        const playBtn = document.getElementById('profile-video-play-btn');
        const playIcon = document.getElementById('play-icon');
        const pauseIcon = document.getElementById('pause-icon');
        
        if (video) {
            video.addEventListener('ended', function() {
                if (playBtn) playBtn.style.opacity = '1';
                if (playIcon) playIcon.classList.remove('hidden');
                if (pauseIcon) pauseIcon.classList.add('hidden');
            });
            
            video.addEventListener('pause', function() {
                if (playBtn) playBtn.style.opacity = '1';
                if (playIcon) playIcon.classList.remove('hidden');
                if (pauseIcon) pauseIcon.classList.add('hidden');
            });

            video.addEventListener('play', function() {
                if (playBtn) playBtn.style.opacity = '0';
                if (playIcon) playIcon.classList.add('hidden');
                if (pauseIcon) pauseIcon.classList.remove('hidden');
            });

            // Click on video to toggle playback
            video.addEventListener('click', function(e) {
                e.preventDefault();
                toggleProfileVideo();
            });
        }
    });
</script>
@endpush