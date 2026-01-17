<div>
    @if (session()->has('message'))
    <div class="alert alert-success flex items-center justify-between mb-6">
        <div class="flex items-center font-semibold">
            <x-icons name="bell" class="w-5 h-5 mr-2.5" />
            <span>{{ session('message') }}</span>
        </div>
        <button type="button" class="flex items-center ml-2 text-gray-400 hover:text-gray-600" onclick="this.parentElement.remove()">
            <x-icons name="cross" class="text-green-800 w-3 h-3" />
        </button>
    </div>
    @endif

    @if (session()->has('info'))
    <div class="alert alert-info flex items-center justify-between mb-6 bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-lg">
        <div class="flex items-center font-semibold">
            <x-icons name="bell" class="w-5 h-5 mr-2.5" />
            <span>{{ session('info') }}</span>
        </div>
        <button type="button" class="flex items-center ml-2 text-gray-400 hover:text-gray-600" onclick="this.parentElement.remove()">
            <x-icons name="cross" class="text-blue-800 w-3 h-3" />
        </button>
    </div>
    @endif

    <!-- Main Photo Section -->
    <div class="mb-10">
        <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('front.profiles.photos.main_photo') }}</h2>
        
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Main Photo Display -->
            <div class="relative w-40 shrink-0">
                @if($mainPhoto)
                    <div class="relative group">
                        <img 
                            src="{{ $mainPhoto->hasGeneratedConversion('medium') ? $mainPhoto->getUrl('medium') : $mainPhoto->getUrl() }}" 
                            alt="{{ __('front.profiles.photos.main_photo') }}" 
                            class="w-40 aspect-[3/4] object-cover rounded-2xl border-2 border-gray-200 shadow-sm">
                        <button 
                            type="button"
                            wire:click="removeExistingImage({{ $mainPhoto->id }})"
                            wire:confirm="{{ __('front.profiles.photos.delete_confirm') }}"
                            class="absolute -top-2 -right-2 bg-primary text-white rounded-full w-7 h-7 flex items-center justify-center shadow-lg hover:bg-primary-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @else
                    <div class="w-40 aspect-[3/4] bg-gray-100 rounded-2xl flex items-center justify-center border-2 border-dashed border-gray-300">
                        <div class="text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-xs">{{ __('front.profiles.photos.no_main') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Save Changes Button (under main photo) -->
                @if($mainPhoto)
                <button
                    type="button"
                    class="mt-4 w-full flex items-center justify-center gap-2 py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-medium transition-colors"
                    wire:click="$refresh">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    {{ __('front.profiles.photos.save_changes') }}
                </button>
                @endif
            </div>

            <!-- Verification Panel -->
            <div class="flex-1">
                @if($this->isProfileVerified())
                    <!-- Verified Status -->
                    <div class="bg-green-50 border border-green-200 rounded-2xl p-6 text-center">
                        <div class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-1.5 rounded-full text-sm font-semibold mb-4">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            {{ __('front.profiles.photos.verified_badge') }}
                        </div>
                        <div class="w-20 h-20 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-green-800 mb-2">{{ __('front.profiles.photos.verified_title') }}</h3>
                        <p class="text-sm text-green-600">{{ __('front.profiles.photos.verified_desc') }}</p>
                    </div>
                @elseif($this->isVerificationPending())
                    <!-- Pending Status -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
                        <div class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-4 py-1.5 rounded-full text-sm font-semibold mb-4">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            {{ __('front.profiles.photos.pending_badge') }}
                        </div>
                        <div class="w-20 h-20 mx-auto mb-4 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-yellow-500 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-yellow-800 mb-2">{{ __('front.profiles.photos.pending_title') }}</h3>
                        <p class="text-sm text-yellow-600">{{ __('front.profiles.photos.pending_desc') }}</p>
                    </div>
                @elseif($this->isVerificationRejected())
                    <!-- Rejected Status -->
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                        <div class="inline-flex items-center gap-2 bg-red-100 text-red-700 px-4 py-1.5 rounded-full text-sm font-semibold mb-4">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            {{ __('front.profiles.photos.rejected_badge') }}
                        </div>
                        <h3 class="text-lg font-bold text-red-800 mb-2">{{ __('front.profiles.photos.rejected_title') }}</h3>
                        <p class="text-sm text-red-600 mb-4">{{ __('front.profiles.photos.rejected_desc') }}</p>
                        <button
                            type="button"
                            wire:click="requestVerification"
                            wire:loading.attr="disabled"
                            class="btn-primary w-full sm:w-auto">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            {{ __('front.profiles.photos.try_again') }}
                        </button>
                    </div>
                @elseif($mainPhoto)
                    <!-- Not Verified - Can Request -->
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ __('front.profiles.photos.verify_title') }}</h3>
                        <p class="text-sm text-gray-600 mb-6">{{ __('front.profiles.photos.verify_desc') }}</p>
                        <button
                            type="button"
                            wire:click="requestVerification"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            class="w-full flex items-center justify-center gap-3 py-3 px-6 bg-primary hover:bg-primary-600 text-white rounded-xl font-semibold transition-colors shadow-lg shadow-primary/25">
                            <span wire:loading.remove>{{ __('front.profiles.photos.verify_button') }}</span>
                            <span wire:loading>{{ __('front.profiles.photos.processing') }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>
                @else
                    <!-- No Main Photo - Upload First -->
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ __('front.profiles.photos.upload_first_title') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('front.profiles.photos.upload_first_desc') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Other Photos Section -->
    <div class="mb-10">
        <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('front.profiles.photos.other_photos') }}</h2>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($otherPhotos as $image)
            <div class="relative group">
                <img 
                    src="{{ $image->hasGeneratedConversion('thumb') ? $image->getUrl('thumb') : $image->getUrl() }}" 
                    alt="Profile image" 
                    class="w-full aspect-[3/4] object-cover rounded-2xl border border-gray-200 cursor-pointer hover:shadow-lg transition-all"
                    onclick="openImageModal('{{ addslashes($image->getUrl()) }}')">
                
                <!-- Delete Button -->
                <button 
                    type="button"
                    wire:click="removeExistingImage({{ $image->id }})"
                    wire:confirm="{{ __('front.profiles.photos.delete_confirm') }}"
                    class="absolute -top-2 -right-2 bg-primary text-white rounded-full w-7 h-7 flex items-center justify-center shadow-lg hover:bg-primary-600 transition-colors opacity-0 group-hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Set as Main Button -->
                <button 
                    type="button"
                    wire:click="setAsMainPhoto({{ $image->id }})"
                    class="absolute bottom-2 left-2 right-2 bg-white/90 backdrop-blur-sm text-gray-700 rounded-lg py-1.5 px-2 text-xs font-medium opacity-0 group-hover:opacity-100 transition-opacity hover:bg-white">
                    {{ __('front.profiles.photos.set_as_main') }}
                </button>
            </div>
            @endforeach

            <!-- Add Photo Button -->
            <label class="relative w-full aspect-[3/4] bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center cursor-pointer hover:border-primary hover:bg-primary-50 transition-colors">
                <input 
                    type="file" 
                    wire:model="images" 
                    multiple 
                    accept="image/*"
                    class="hidden">
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-2 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-primary">{{ __('front.profiles.photos.add_more') }}</span>
                </div>
                <div wire:loading wire:target="images" class="absolute inset-0 bg-white/80 rounded-2xl flex items-center justify-center">
                    <svg class="animate-spin h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </label>
        </div>

        @error('images.*') 
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
        @enderror
    </div>

    <!-- Preview Uploaded Images -->
    @if(!empty($images))
    <div class="mb-10 bg-primary-50 border border-primary-200 rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('front.profiles.photos.preview') }}</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-4">
            @foreach($images as $index => $image)
            <div class="relative group">
                @if($image)
                <img 
                    src="{{ $image->temporaryUrl() }}" 
                    alt="Preview" 
                    class="w-full aspect-[3/4] object-cover rounded-2xl border border-primary-200">
                <button 
                    type="button"
                    wire:click="removeUploadedImage({{ $index }})"
                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-lg hover:bg-red-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                @endif
            </div>
            @endforeach
        </div>

        <div class="flex items-center justify-between">
            <p class="text-xs text-gray-500">{{ __('front.profiles.photos.formats') }}</p>
            <button
                type="button"
                wire:click="uploadImages"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed"
                class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <span wire:loading.remove wire:target="uploadImages">{{ __('front.profiles.photos.upload_button') }}</span>
                <span wire:loading wire:target="uploadImages">{{ __('front.profiles.photos.uploading') }}</span>
            </button>
        </div>
    </div>
    @endif

    <!-- No Photos Message -->
    @if((!$existingImages || $existingImages->count() === 0) && empty($images))
    <div class="card p-6">
        <div class="text-center py-8">
            <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('front.profiles.photos.nophotos') }}</h3>
            <p class="text-sm text-gray-500 mb-6">{{ __('front.profiles.photos.nophotos_desc') }}</p>
            
            <label class="inline-flex items-center justify-center gap-2 py-3 px-6 bg-primary hover:bg-primary-600 text-white rounded-xl font-semibold transition-colors cursor-pointer">
                <input 
                    type="file" 
                    wire:model="images" 
                    multiple 
                    accept="image/*"
                    class="hidden">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('front.profiles.photos.upload_first') }}
            </label>
        </div>
    </div>
    @endif

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 p-4" style="display: none; align-items: center; justify-content: center;">
        <div class="relative max-w-4xl max-h-full">
            <img id="modalImage" src="" alt="Full size image" class="max-w-full max-h-full object-contain rounded-lg">
            <button 
                onclick="closeImageModal()"
                class="absolute top-4 right-4 bg-white text-gray-800 rounded-full p-2 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        function openImageModal(imageUrl) {
            const modal = document.getElementById('imageModal');
            document.getElementById('modalImage').src = imageUrl;
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</div>