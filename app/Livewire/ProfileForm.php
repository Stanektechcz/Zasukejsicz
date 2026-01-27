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

    // Password change fields
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    // Email change fields
    public $new_email = '';
    public $email_change_password = '';

    #[Rule('nullable|string|max:255')]
    public $country = '';

    // Profile model fields
    #[Rule('nullable|string|max:255')]
    public $display_name = '';

    #[Rule('nullable|integer|min:18|max:120')]
    public $age = '';

    #[Rule('nullable|string|max:255')]  
    public $city = '';

    #[Rule('nullable|string|max:2')]
    public $country_code = '';

    #[Rule('nullable|string|max:255')]
    public $address = '';

    #[Rule('nullable|string|max:1200')]
    public $about = '';

    #[Rule('boolean')]
    public $incall = false;

    #[Rule('boolean')]
    public $outcall = false;

    #[Rule('boolean')]
    public $is_porn_actress = false;

    #[Rule('nullable|string')]
    public $availability_hours = '';

    public $local_prices = [];

    public $global_prices = [];

    public $contacts = [];

    #[Rule('nullable|in:pending,approved,rejected')]
    public $status = '';

    public $is_public = false;

    // Dropdown states
    public $countryDropdownOpen = false;
    public $countrySearchTerm = '';
    
    // City autocomplete states
    public $cityDropdownOpen = false;
    public $citySearchTerm = '';
    public $citySuggestions = [];

    // Options arrays
    public $countries = [];

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
            $this->age = $profile->age ?? '';
            $this->city = $profile->city ?? '';
            $this->citySearchTerm = $profile->city ?? ''; // Initialize city search with existing value
            $this->country_code = $profile->country_code ?? '';
            $this->address = $profile->address ?? '';
            $this->about = $profile->about ?? '';
            $this->incall = $profile->incall ?? false;
            $this->outcall = $profile->outcall ?? false;
            $this->is_porn_actress = $profile->is_porn_actress ?? false;
            $this->availability_hours = is_array($profile->availability_hours) 
                ? implode(', ', $profile->availability_hours) 
                : ($profile->availability_hours ?? '');
            $this->local_prices = is_array($profile->local_prices) 
                ? $profile->local_prices 
                : [];
            $this->global_prices = is_array($profile->global_prices) 
                ? $profile->global_prices 
                : [];
            $this->contacts = is_array($profile->contacts) 
                ? $profile->contacts 
                : [];
            $this->status = $profile->status ?? '';
            $this->is_public = $profile->is_public ?? false;
        }

        // Load dropdown options
        $this->loadCountries();
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



    public function loadCountries()
    {
        $codes = include base_path('lang/en/codes.php');
        $this->countries = collect($codes)->map(function ($name, $code) {
            return [
                'code' => strtolower($code),
                'name' => $name,
            ];
        })->sortBy('name')->values()->toArray();
    }

    public function toggleCountryDropdown()
    {
        $this->countryDropdownOpen = !$this->countryDropdownOpen;
        $this->countrySearchTerm = '';
    }

    public function selectCountry($countryCode)
    {
        $this->country_code = $countryCode;
        $this->countryDropdownOpen = false;
        $this->countrySearchTerm = '';
        
        // Clear city when country changes (city must match country)
        $this->city = '';
        $this->citySearchTerm = '';
        $this->citySuggestions = [];
    }

    /**
     * Search cities based on country and search term
     */
    public function updatedCitySearchTerm($value)
    {
        if (empty($this->country_code) || strlen($value) < 2) {
            $this->citySuggestions = [];
            return;
        }
        
        $this->citySuggestions = \App\Models\City::autocomplete(
            $this->country_code,
            $value,
            10
        )->toArray();
    }

    /**
     * Select a city from suggestions
     */
    public function selectCity($cityName)
    {
        $this->city = $cityName;
        $this->citySearchTerm = $cityName;
        $this->citySuggestions = [];
        $this->cityDropdownOpen = false;
    }

    /**
     * Toggle city dropdown
     */
    public function toggleCityDropdown()
    {
        if (empty($this->country_code)) {
            return; // Don't open if no country selected
        }
        $this->cityDropdownOpen = !$this->cityDropdownOpen;
    }

    public function getFilteredCountriesProperty()
    {
        if (empty($this->countrySearchTerm)) {
            return $this->countries;
        }

        return array_filter($this->countries, function ($country) {
            return stripos($country['name'], $this->countrySearchTerm) !== false;
        });
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

    public function addContact()
    {
        $this->contacts[] = [
            'type' => 'phone',
            'value' => ''
        ];
    }

    public function removeContact($index)
    {
        unset($this->contacts[$index]);
        $this->contacts = array_values($this->contacts);
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
            'age' => 'nullable|integer|min:18|max:120',
            'city' => 'nullable|string|max:255',
            'country_code' => 'nullable|string|max:2',
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
            'contacts' => 'nullable|array',
            'contacts.*.type' => 'required|in:phone,whatsapp,telegram',
            'contacts.*.value' => 'required|string|max:255',
        ];

        // Add status validation only for admin users
        if ($isAdmin) {
            $validationRules['status'] = 'nullable|in:pending,approved,rejected';
        }

        // Add password validation rules if user is changing password
        if (!empty($this->current_password) || !empty($this->new_password) || !empty($this->new_password_confirmation)) {
            $validationRules['current_password'] = 'required|current_password';
            $validationRules['new_password'] = 'required|string|min:8|confirmed';
        }

        // Add email change validation rules if user is changing email
        if (!empty($this->new_email)) {
            $validationRules['new_email'] = 'required|email|max:255|unique:users,email,' . $user->id;
            $validationRules['email_change_password'] = 'required|current_password';
        }

        $this->validate($validationRules);

        // Track email change before update
        $emailChanged = !empty($this->new_email) && $user->email !== $this->new_email;

        // Update user data
        $user->name = $this->name;
        if ($emailChanged) {
            $user->email = $this->new_email;
        }
        $user->phone = $this->phone;

        // Mark email as unverified if changed and send verification notification
        if ($emailChanged) {
            $user->email_verified_at = null;
            // Clear email change fields
            $this->email = $this->new_email;
            $this->new_email = '';
            $this->email_change_password = '';
        }

        // Update password if provided
        if (!empty($this->new_password)) {
            $user->password = bcrypt($this->new_password);
            // Clear password fields after update
            $this->current_password = '';
            $this->new_password = '';
            $this->new_password_confirmation = '';
        }

        $user->save();

        // Send email verification notification after save if email changed
        if ($emailChanged) {
            $user->sendEmailVerificationNotification();
        }

        // Update or create profile
        $profileData = [
            'display_name' => $this->display_name ?: null,
            'age' => $this->age ?: null,
            'city' => $this->city ?: null,
            'country_code' => $this->country_code ? strtolower($this->country_code) : null,
            'address' => $this->address ?: null,
            'about' => $this->about ?: null,
            'incall' => $this->incall,
            'outcall' => $this->outcall,
            'is_porn_actress' => $this->is_porn_actress,
            'availability_hours' => $this->availability_hours ? explode(', ', $this->availability_hours) : null,
            'local_prices' => $this->local_prices ?: null,
            'global_prices' => $this->global_prices ?: null,
            'contacts' => $this->contacts ?: null,
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

            // Notify admins about new profile submission
            $admins = \App\Models\User::role('admin')->get();
            foreach ($admins as $admin) {
                \App\Models\Notification::createForUser(
                    $admin->id,
                    __('notifications.admin.new_profile_title'),
                    __('notifications.admin.new_profile_message', ['name' => $profile->display_name]),
                    'info'
                );
            }
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
