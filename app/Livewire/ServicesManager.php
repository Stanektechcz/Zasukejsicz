<?php

namespace App\Livewire;

use App\Models\Profile;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ServicesManager extends Component
{
    // Profile state
    public $hasProfile = false;
    public $profile = null;

    // Services state
    public $services = [];
    public $selectedServices = [];

    public function mount()
    {
        // Get user with profile relationship loaded
        $user = \App\Models\User::with('profile')->find(Auth::id());
        $this->profile = $user->profile;

        // Set profile state
        $this->hasProfile = !is_null($this->profile);

        // Load all active services
        $this->services = Service::active()->ordered()->get();

        // Load selected services for this profile
        if ($this->hasProfile) {
            $this->selectedServices = $this->profile->services->pluck('id')->toArray();
        }
    }

    public function toggleService($serviceId)
    {
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
            $this->profile = $profile;
        } else {
            $this->profile = $user->profile;
        }

        // Toggle the service
        $this->profile->toggleService($serviceId);

        // Refresh selected services
        $this->selectedServices = $this->profile->fresh()->services->pluck('id')->toArray();

        session()->flash('message', 'Služba byla úspěšně aktualizována!');
    }

    public function render()
    {
        return view('livewire.services-manager');
    }
}

