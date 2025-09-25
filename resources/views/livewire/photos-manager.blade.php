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

    <!-- Upload Section -->
    <div class="card p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Nahrát nové fotografie</h2>
        
        <form wire:submit="uploadImages" class="space-y-4">
            <!-- File Input -->
            <div>
                <input 
                    type="file" 
                    wire:model="images" 
                    multiple 
                    accept="image/*"
                    class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100">
                @error('images.*') 
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Preview Uploaded Images -->
            @if(!empty($images))
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Náhled nových fotografií:</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($images as $index => $image)
                    <div class="relative group">
                        @if($image)
                        <img 
                            src="{{ $image->temporaryUrl() }}" 
                            alt="Preview" 
                            class="w-full h-32 object-cover rounded-lg border border-gray-200">
                        <button 
                            type="button"
                            wire:click="removeUploadedImage({{ $index }})"
                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Upload Button -->
            @if(!empty($images))
            <div class="flex justify-end">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                    class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <span wire:loading.remove>Nahrát fotografie</span>
                    <span wire:loading>Nahrávám...</span>
                </button>
            </div>
            @endif

            <p class="text-xs text-gray-500">Podporované formáty: JPG, JPEG, PNG, GIF. Maximální velikost souboru: 10MB.</p>
        </form>
    </div>

    <!-- Existing Photos Gallery -->
    @if($existingImages && $existingImages->count() > 0)
    <div class="card p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Moje fotografie ({{ $existingImages->count() }})</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($existingImages as $image)
            <div class="relative group">
                <img 
                    src="{{ $image->getUrl() }}" 
                    alt="Profile image" 
                    class="w-full h-48 object-cover rounded-lg border border-gray-200 cursor-pointer hover:shadow-lg transition-shadow"
                    onclick="openImageModal('{{ addslashes($image->getUrl()) }}')">
                <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-60 transition-all rounded-lg flex items-center justify-center">
                    <button 
                        type="button"
                        wire:click="removeExistingImage({{ $image->id }})"
                        wire:confirm="Opravdu chcete smazat tuto fotografii?"
                        class="bg-red-500 text-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <!-- No Photos Message -->
    <div class="card p-6">
        <div class="text-center py-8">
            <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Zatím nemáte žádné fotografie</h3>
            <p class="text-sm text-gray-500">Nahrajte své první fotografie pomocí formuláře výše.</p>
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