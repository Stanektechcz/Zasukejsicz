<?php

namespace App\Livewire;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

class PhotosManager extends Component
{
    use WithFileUploads;

    // Image upload properties
    public $images = [];
    public $existingImages = [];

    // Profile state
    public $hasProfile = false;

    public function mount()
    {
        // Get user with profile relationship loaded
        $user = \App\Models\User::with('profile')->find(Auth::id());
        $profile = $user->profile;

        // Set profile state
        $this->hasProfile = !is_null($profile);

        // Load existing images if profile exists
        if ($profile) {
            $this->existingImages = $profile->getMedia('profile-images');
        }
    }

    public function removeExistingImage($mediaId)
    {
        $user = Auth::user();
        if ($user->profile) {
            $media = $user->profile->getMedia('profile-images')->where('id', $mediaId)->first();
            if ($media) {
                $media->delete();
            // Refresh existing images
            $this->existingImages = $user->profile->fresh()->getMedia('profile-images');                session()->flash('message', 'Fotografie byla úspěšně smazána!');
            }
        }
    }

    public function removeUploadedImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->images = array_values($this->images); // Reindex array
        }
    }

    public function uploadImages()
    {
        $this->validate([
            'images.*' => 'image|max:10240', // Max 10MB per image
        ]);

        $user = Auth::user();
        
        // Ensure user has a profile
        if (!$user->profile) {
            // Create basic profile if it doesn't exist
            $profile = new Profile([
                'display_name' => $user->name,
                'status' => 'pending',
                'is_public' => false,
            ]);
            $profile->user_id = $user->id;
            $profile->save();
            
            $this->hasProfile = true;
        } else {
            $profile = $user->profile;
        }

        // Handle image uploads
        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                if ($image instanceof UploadedFile) {
                    // Add each file individually to the media collection
                    $profile->addMedia($image->path())
                        ->usingName($image->getClientOriginalName())
                        ->usingFileName($image->hashName())
                        ->toMediaCollection('profile-images');
                }
            }
            
            // Clear uploaded images after saving
            $this->images = [];
            
            // Refresh existing images
            $this->existingImages = $profile->fresh()->getMedia('profile-images');
            
            session()->flash('message', 'Fotografie byly úspěšně nahrány!');
        }
    }

    public function render()
    {
        return view('livewire.photos-manager');
    }
}