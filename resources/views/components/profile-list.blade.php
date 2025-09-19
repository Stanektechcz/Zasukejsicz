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
        <div class="card max-w-md mx-auto">
            <div class="text-red-600 mb-4">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-lg font-medium" x-text="$store.profiles.error"></p>
            </div>
            <button class="btn btn-primary" @click="$store.profiles.fetchProfiles()">
                {{ __('Try Again') }}
            </button>
        </div>
    </div>

    <!-- Profiles Grid -->
    <div x-show="$store.profiles.data.length > 0">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <template x-for="profile in $store.profiles.data" :key="profile.id">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <!-- Profile Image -->
                    <div class="relative">
                        <!-- Verified Badge -->
                        <div x-show="profile.is_verified" class="absolute top-3 left-3 z-10 flex flex-col items-start gap-1">
                            <div class="bg-green-100 text-green-500 p-1 px-0.5 rounded-xl flex flex-wrap justify-center"> 
                                <x-icons name="camera" class="w-5 h-5" />
                                <p class="text-xs font-bold w-full text-center">
                                    OVĚŘENO
                                </p>
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
                        <div class="flex items-center justify-between py-3">
                            <h4 class="text-gray-700 flex-grow-0 truncate max-w-[80%]" x-text="profile.display_name"></h4>
                            <div x-show="!profile.is_vip" class="bg-gold-500 text-white px-2 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                <x-icons name="star" class="w-3 h-3" />
                                VIP
                            </div>
                        </div>

                        <!-- Details Button -->
                        <button @click="window.location.href = `/profiles/${profile.id}`" class="w-full py-3 px-5 rounded-lg bg-secondary-600 hover:bg-secondary-700 text-white font-semibold transition-colors duration-200 flex items-center justify-between">
                            <span class="text-lg">Detail</span>
                            <x-icons name="search" class="w-5 h-5 text-white" strokeWidth="3" />
                        </button>

                        <!-- Rating/Evaluation -->
                        <div>
                             <div class="flex bg-gray-200 rounded-lg justify-between">
                                <div class="flex-1 bg-gray-100 rounded-lg p-3 py-2">
                                    <div class="text-sm font-medium text-gray-700">Hodnocení:</div>
                                </div>
                                <div class="flex-1 rounded-r-lg px-2 py-2 flex items-center justify-center">
                                    <x-icons name="lock" class="w-4 h-4 text-primary"  />
                                </div>
                            </div>
                            

                            <!-- Location -->
                            <div x-show="profile.city" class="flex py-2 justify-center items-center gap-x-2 text-sm text-primary-600">
                                <x-icons name="location" class="w-4 h-4 -translate-y-0.5" />
                                <h5 class="py-1 text-center" x-text="profile.city"></h5>
                            </div>

                           <div class="flex justify-between gap-x-3">
                                <div class="flex-1 bg-gray-100 rounded-lg p-3 text-center">
                                    <div class="text-xs ">168 cm</div>
                                </div>
                                <div class="flex-1 bg-gray-100 rounded-lg p-3 text-center">
                                    <div class="text-xs ">19 let</div>
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
        <h3 class="text-gray-500 mb-2">{{ __('No therapists found') }}</h3>
        <p class="text-gray-600 mb-6">{{ __('Try adjusting your search criteria or browse all available therapists.') }}</p>

        <a href="#" class="btn btn-primary" @click="$store.profiles.resetFilters()">
            <a href="#" class="btn btn-primary">
                {{ __('Show All Therapists') }}
            </a>
        </a>
    </div>
</div>