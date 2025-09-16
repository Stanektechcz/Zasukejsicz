@props(['initialProfiles' => collect(), 'initialPagination' => null])

<div x-data="profileList({ initialProfiles: {{ json_encode($initialProfiles) }}, initialPagination: {{ json_encode($initialPagination) }} })" class="space-y-6">
    <!-- Loading State -->
    <div x-show="$store.profiles.loading && !$store.profiles.data.length" class="text-center py-8">
        <div class="inline-flex items-center px-4 py-2 text-gray-600">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ __('Loading profiles...') }}
        </div>
    </div>

    <!-- Error State -->
    <div x-show="$store.profiles.error" class="text-center py-8">
        <x-card class="max-w-md mx-auto">
            <div class="text-red-600 mb-4">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-lg font-medium" x-text="$store.profiles.error"></p>
            </div>
            <button class="btn btn-primary" @click="$store.profiles.fetchProfiles()">
                {{ __('Try Again') }}
            </button>
        </x-card>
    </div>

    <!-- Profiles Grid -->
    <div x-show="$store.profiles.data.length > 0">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <template x-for="profile in $store.profiles.data" :key="profile.id">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <!-- Profile Image -->
                    <div class="relative">
                        <!-- Verified Badge -->
                        <div x-show="profile.is_verified" class="absolute top-3 left-3 z-10">
                            <div class="bg-green-500 text-white px-2 py-1 rounded-lg text-xs font-medium flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                OVĚŘENO
                            </div>
                        </div>

                        <!-- Profile Photo -->
                        <div class="aspect-[4/5] bg-gradient-to-br from-primary-100 to-secondary-100 flex items-center justify-center">
                            <template x-if="profile.photo_url">
                                <img :src="profile.photo_url" :alt="profile.display_name"
                                    class="w-full h-full object-cover">
                            </template>
                            <template x-if="!profile.photo_url">
                                <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </template>
                        </div>
                    </div>

                    <!-- Profile Info -->
                    <div class="p-4 space-y-3">
                        <!-- Name and VIP Badge -->
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-lg text-gray-900 truncate" x-text="profile.display_name"></h3>
                            <div x-show="profile.is_vip" class="bg-gold-500 text-white px-2 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                VIP
                            </div>
                        </div>

                        <!-- Details Button -->
                        <button class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <span>Detail</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        <!-- Rating/Evaluation -->
                        <div class="bg-gray-100 rounded-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Hodnocení:</span>
                                <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                </svg>
                            </div>

                            <!-- Location -->
                            <div x-show="profile.city" class="flex items-center text-sm text-primary-600 mb-2">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span x-text="profile.city"></span>
                            </div>

                            <!-- Stats -->
                            <div class="flex justify-between text-center">
                                <div>
                                    <div class="text-lg font-bold text-gray-900" x-text="profile.height || '168'"></div>
                                    <div class="text-xs text-gray-500">cm</div>
                                </div>
                                <div>
                                    <div class="text-lg font-bold text-gray-900" x-text="profile.age || '19'"></div>
                                    <div class="text-xs text-gray-500">let</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Load More Button -->
        <div x-show="$store.profiles.canLoadMore" class="text-center mt-8">
            <button @click="loadMore()"
                x-bind:disabled="$store.profiles.loading"
                class="inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed shadow hover:shadow-md px-8 py-3 text-base bg-secondary-600 text-white hover:bg-secondary-700 focus:ring-secondary-500">
                <span x-show="!$store.profiles.loading">Load More Profiles</span>
                <span x-show="$store.profiles.loading" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Loading...
                </span>
            </button>
        </div>

        <!-- Results Count -->
        <div class="text-center text-sm text-gray-600 mt-4">
            <span x-text="`Showing ${$store.profiles.data.length} of ${$store.profiles.pagination.total} profiles`"></span>
        </div>
    </div>

    <!-- Empty State -->
    <div x-show="!$store.profiles.loading && !$store.profiles.data.length && !$store.profiles.error" class="text-center py-16">
        <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <x-heading size="h3" class="text-gray-500 mb-2">{{ __('No therapists found') }}</x-heading>
        <p class="text-gray-600 mb-6">{{ __('Try adjusting your search criteria or browse all available therapists.') }}</p>

        <a href="#" class="btn btn-primary" @click="$store.profiles.resetFilters()">
            <a href="#" class="btn btn-primary">
                {{ __('Show All Therapists') }}
            </a>
        </a>
    </div>
</div>