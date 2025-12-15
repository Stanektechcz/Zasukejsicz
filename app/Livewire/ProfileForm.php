<?php

namespace App\Livewire;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Rule;

class ProfileForm extends Component
{
    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|email|max:255')]
    public $email = '';

    #[Rule('nullable|string|max:20|unique:users,phone')]
    public $phone = '';

    #[Rule('nullable|string|max:255')]
    public $country = '';

    // Profile model fields
    #[Rule('nullable|string|max:255')]
    public $display_name = '';

    #[Rule('nullable|in:male,female')]
    public $gender = '';

    #[Rule('nullable|integer|min:18|max:120')]
    public $age = '';

    #[Rule('nullable|string|max:255')]  
    public $city = '';

    #[Rule('nullable|string|max:255')]
    public $address = '';

    #[Rule('nullable|string|max:1200')]
    public $about = '';

    #[Rule('boolean')]
    public $incall = false;

    #[Rule('boolean')]
    public $outcall = false;

    #[Rule('nullable|string')]
    public $availability_hours = '';

    public $local_prices = [];

    public $global_prices = [];

    #[Rule('nullable|in:pending,approved,rejected')]
    public $status = '';

    public $is_public = false;

    // Dropdown states
    public $genderDropdownOpen = false;

    // Options arrays
    public $genders = [];

    // Profile state
    public $hasProfile = false;

    public function mount()
    {
        // Get user with profile relationship loaded
        $user = \App\Models\User::with('profile')->find(Auth::id());
        $profile = $user->profile;

        // Set profile state
        $this->hasProfile = !is_null($profile);

        // Load user data
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';

        // Load profile data if exists
        if ($profile) {
            $this->display_name = $profile->display_name ?? '';
            $this->gender = $profile->gender ?? '';
            $this->age = $profile->age ?? '';
            $this->city = $profile->city ?? '';
            $this->address = $profile->address ?? '';
            $this->about = $profile->about ?? '';
            $this->incall = $profile->incall ?? false;
            $this->outcall = $profile->outcall ?? false;
            $this->availability_hours = is_array($profile->availability_hours) 
                ? implode(', ', $profile->availability_hours) 
                : ($profile->availability_hours ?? '');
            $this->local_prices = is_array($profile->local_prices) 
                ? $profile->local_prices 
                : [];
            $this->global_prices = is_array($profile->global_prices) 
                ? $profile->global_prices 
                : [];
            $this->status = $profile->status ?? '';
            $this->is_public = $profile->is_public ?? false;
        }

        // Load dropdown options
        $this->loadGenders();
    }

    /**
     * Check if the current user is an admin.
     */
    public function isAdmin(): bool
    {
        $user = \App\Models\User::with('roles')->find(Auth::id());
        return $user->roles()->where('name', 'admin')->exists();
    }

    /**
     * Get the status label with translation.
     */
    public function getStatusLabel(): string
    {
        $statusLabels = [
            'pending' => __('front.profiles.form.pending'),
            'approved' => __('front.profiles.form.approved'),
            'rejected' => __('front.profiles.form.rejected'),
        ];

        return $statusLabels[$this->status] ?? $statusLabels['pending'];
    }

    /**
     * Get the status color for display.
     */
    public function getStatusColor(): string
    {
        $statusColors = [
            'pending' => 'text-yellow-600 bg-yellow-50 border-yellow-200',
            'approved' => 'text-green-600 bg-green-50 border-green-200',
            'rejected' => 'text-red-600 bg-red-50 border-red-200',
        ];

        return $statusColors[$this->status] ?? $statusColors['pending'];
    }



    public function loadGenders()
    {
        $this->genders = [
            'male' => 'Muž',
            'female' => 'Žena'
        ];
    }

    public function toggleGenderDropdown()
    {
        $this->genderDropdownOpen = !$this->genderDropdownOpen;
    }

    public function selectGender($gender)
    {
        $this->gender = $gender;
        $this->genderDropdownOpen = false;
    }

    public function addLocalPrice()
    {
        $this->local_prices[] = [
            'time_hours' => '',
            'incall_price' => '',
            'outcall_price' => ''
        ];
    }

    public function removeLocalPrice($index)
    {
        unset($this->local_prices[$index]);
        $this->local_prices = array_values($this->local_prices);
    }

    public function addGlobalPrice()
    {
        $this->global_prices[] = [
            'time_hours' => '',
            'incall_price' => '',
            'outcall_price' => ''
        ];
    }

    public function removeGlobalPrice($index)
    {
        unset($this->global_prices[$index]);
        $this->global_prices = array_values($this->global_prices);
    }

    public function save()
    {
        $user = Auth::user();
        $user = \App\Models\User::find($user->id);
        $isAdmin = $this->isAdmin();
        
        // Build validation rules - exclude status for non-admin users
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id,
            'display_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'age' => 'nullable|integer|min:18|max:120',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'about' => 'nullable|string|max:1200',
            'availability_hours' => 'nullable|string',
            'local_prices' => 'nullable|array',
            'local_prices.*.time_hours' => 'required|string|max:100',
            'local_prices.*.incall_price' => 'required|numeric|min:0',
            'local_prices.*.outcall_price' => 'nullable|numeric|min:0',
            'global_prices' => 'nullable|array',
            'global_prices.*.time_hours' => 'required|string|max:100',
            'global_prices.*.incall_price' => 'required|numeric|min:0',
            'global_prices.*.outcall_price' => 'nullable|numeric|min:0',
        ];

        // Add status validation only for admin users
        if ($isAdmin) {
            $validationRules['status'] = 'nullable|in:pending,approved,rejected';
        }

        $this->validate($validationRules);

        // Track email change before update
        $emailChanged = $user->email !== $this->email;

        // Update user data
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;

        // Mark email as unverified if changed
        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update or create profile
        $profileData = [
            'display_name' => $this->display_name ?: null,
            'gender' => $this->gender ?: null,
            'age' => $this->age ?: null,
            'city' => $this->city ?: null,
            'address' => $this->address ?: null,
            'about' => $this->about ?: null,
            'incall' => $this->incall,
            'outcall' => $this->outcall,
            'availability_hours' => $this->availability_hours ? explode(', ', $this->availability_hours) : null,
            'local_prices' => $this->local_prices ?: null,
            'global_prices' => $this->global_prices ?: null,
            'is_public' => $this->is_public,
        ];

        // Only include status if user is admin, otherwise set default for new profiles
        if ($isAdmin) {
            $profileData['status'] = $this->status ?: 'pending';
        } elseif (!$user->profile) {
            // For new profiles by non-admin users, set default status
            $profileData['status'] = 'pending';
        }

        if ($user->profile) {
            // Update existing profile
            $profile = $user->profile;
            foreach ($profileData as $key => $value) {
                $profile->$key = $value;
            }
            $profile->save();
        } else {
            // Create new profile
            $profile = new Profile($profileData);
            $profile->user_id = $user->id;
            $profile->save();
            
            // Update the hasProfile property
            $this->hasProfile = true;
        }



        session()->flash('message', 'Profil byl úspěšně uložen!');
        
        // Scroll to top after successful save
        $this->js('window.scrollTo({top: 0, behavior: "smooth"})');
    }

    public function render()
    {
        return view('livewire.profile-form');
    }

    // Debug method to check profile relationship
    public function checkProfile()
    {
        $user = \App\Models\User::with('profile')->find(Auth::id());
        dd([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'profile_exists' => !is_null($user->profile),
            'profile_data' => $user->profile,
            'has_profile_property' => $this->hasProfile
        ]);
    }
}
