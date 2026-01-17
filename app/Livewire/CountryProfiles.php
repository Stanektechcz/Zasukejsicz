<?php

namespace App\Livewire;

use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class CountryProfiles extends Component
{
    use WithPagination;

    public $selectedCountryCode = null;
    public $selectedCity = null;
    public $expandedCountries = [];
    public $perPage = 20;
    
    // Search parameter from redirect
    public $city = '';
    
    // Quick filter properties (matching ProfileList)
    public $ageGroup = ''; // '18-25', '26-30', '31-35', '36-40', '40-50', '50+'
    public $sortRecommendation = ''; // '', 'desc' (best first), 'asc' (worst first)
    public $hasVerifiedPhoto = false;
    public $hasVideo = false;
    public $isPornActress = false;
    public $sortNew = ''; // '', 'desc' (newest first), 'asc' (oldest first)
    public $hasRating = false; // profiles with rating/reviews

    protected $paginationTheme = 'bootstrap';
    
    protected $queryString = [
        'city' => ['except' => ''],
        'ageGroup' => ['except' => '', 'as' => 'age'],
        'sortRecommendation' => ['except' => '', 'as' => 'recommend'],
        'hasVerifiedPhoto' => ['except' => false, 'as' => 'verified_photo'],
        'hasVideo' => ['except' => false, 'as' => 'video'],
        'isPornActress' => ['except' => false, 'as' => 'actress'],
        'sortNew' => ['except' => '', 'as' => 'new'],
        'hasRating' => ['except' => false, 'as' => 'rated'],
    ];

    public function mount()
    {
        // Handle search parameters from redirect
        $this->city = request('city', '');
        $this->ageGroup = request('age', '');
        $this->sortRecommendation = request('recommend', '');
        $this->hasVerifiedPhoto = request()->boolean('verified_photo');
        $this->hasVideo = request()->boolean('video');
        $this->isPornActress = request()->boolean('actress');
        $this->sortNew = request('new', '');
        $this->hasRating = request()->boolean('rated');
        
        if ($this->city) {
            $this->autoSelectCityFromSearch($this->city);
        }
    }
    
    /**
     * Auto-select country and city when coming from search
     */
    private function autoSelectCityFromSearch($searchCity)
    {
        // URL decode the city name in case it's encoded
        $searchCity = urldecode($searchCity);
        
        // First try exact match
        $profile = Profile::where('status', 'approved')
            ->where('is_public', true)
            ->whereNotNull('verified_at')
            ->whereNotNull('country_code')
            ->where('city', $searchCity)
            ->first();
        
        // If no exact match, try case-insensitive partial match
        if (!$profile) {
            $profile = Profile::where('status', 'approved')
                ->where('is_public', true)
                ->whereNotNull('verified_at')
                ->whereNotNull('country_code')
                ->whereRaw('LOWER(city) LIKE ?', ['%' . strtolower($searchCity) . '%'])
                ->first();
        }
            
        if ($profile && $profile->country_code) {
            $this->selectedCountryCode = $profile->country_code;
            $this->selectedCity = $profile->city;
            $this->expandedCountries[] = $profile->country_code;
        }
    }


    public function selectCountry($countryCode = null)
    {
        $this->selectedCountryCode = $countryCode;
        $this->selectedCity = null; // Reset city when changing country
        $this->resetPage();
    }


    public function selectCity($countryCode, $city = null)
    {
        $this->selectedCountryCode = $countryCode;
        $this->selectedCity = $city;
        $this->resetPage();
    }
    
    /**
     * Clear the selected location (country and city)
     */
    public function clearLocation()
    {
        $this->selectedCountryCode = null;
        $this->selectedCity = null;
        $this->city = '';
        $this->expandedCountries = [];
        $this->resetPage();
    }


    public function toggleCountryExpansion($countryCode)
    {
        if (in_array($countryCode, $this->expandedCountries)) {
            $this->expandedCountries = array_diff($this->expandedCountries, [$countryCode]);
        } else {
            $this->expandedCountries[] = $countryCode;
        }
    }

    public function loadMore()
    {
        $this->perPage += 20;
    }
    
    /**
     * Reset all filters
     */
    public function resetFilters()
    {
        $this->reset(['ageGroup', 'sortRecommendation', 'hasVerifiedPhoto', 'hasVideo', 'isPornActress', 'sortNew', 'hasRating']);
        $this->resetPage();
    }

    /**
     * Toggle quick filter methods (matching ProfileList)
     */
    public function toggleAgeGroup($group)
    {
        $this->ageGroup = $this->ageGroup === $group ? '' : $group;
        $this->resetPage();
    }

    public function toggleRecommendation()
    {
        // Cycle through: '' -> 'desc' -> 'asc' -> ''
        if ($this->sortRecommendation === '') {
            $this->sortRecommendation = 'desc';
        } elseif ($this->sortRecommendation === 'desc') {
            $this->sortRecommendation = 'asc';
        } else {
            $this->sortRecommendation = '';
        }
        $this->resetPage();
    }

    public function toggleVerifiedPhoto()
    {
        $this->hasVerifiedPhoto = !$this->hasVerifiedPhoto;
        $this->resetPage();
    }

    public function toggleVideo()
    {
        $this->hasVideo = !$this->hasVideo;
        $this->resetPage();
    }

    public function togglePornActress()
    {
        $this->isPornActress = !$this->isPornActress;
        $this->resetPage();
    }

    public function toggleNew()
    {
        // Cycle through: '' -> 'desc' -> 'asc' -> ''
        if ($this->sortNew === '') {
            $this->sortNew = 'desc';
        } elseif ($this->sortNew === 'desc') {
            $this->sortNew = 'asc';
        } else {
            $this->sortNew = '';
        }
        $this->resetPage();
    }

    public function toggleRating()
    {
        $this->hasRating = !$this->hasRating;
        $this->resetPage();
    }
    
    /**
     * Get active filters count for UI
     */
    public function activeFiltersCount()
    {
        $count = 0;
        if ($this->ageGroup) $count++;
        if ($this->sortRecommendation) $count++;
        if ($this->hasVerifiedPhoto) $count++;
        if ($this->hasVideo) $count++;
        if ($this->isPornActress) $count++;
        if ($this->sortNew) $count++;
        if ($this->hasRating) $count++;
        return $count;
    }

    public function getCountriesProperty()
    {
        $codes = include base_path('lang/en/codes.php');
        $profiles = Profile::query()
            ->where('is_public', true)
            ->whereNotNull('country_code')
            ->whereNotNull('verified_at')
            ->get();

        // Aggregate by country_code
        $countries = collect();
        foreach ($profiles->groupBy('country_code') as $code => $profilesInCountry) {
            $country = [
                'country_code' => $code,
                'country_name' => $codes[strtolower($code)] ?? $code,
                'profiles_count' => $profilesInCountry->count(),
                'cities' => $profilesInCountry->whereNotNull('city')
                    ->groupBy('city')
                    ->map(function ($cityProfiles, $city) {
                        return [
                            'city' => $city,
                            'profiles_count' => $cityProfiles->count(),
                        ];
                    })->sortBy('city')->values(),
            ];
            $countries->push((object) $country);
        }
        // Sort by country_name
        return $countries->sortBy('country_name')->values();
    }

    public function getProfilesProperty()
    {
        $query = Profile::with(['user:id,name', 'media'])
            ->where('status', 'approved')
            ->where('is_public', true)
            ->whereNotNull('verified_at')
            ->orderBy('created_at', 'desc');

        // Location filters
        if ($this->selectedCountryCode) {
            $query->where('country_code', $this->selectedCountryCode);
        }

        if ($this->selectedCity) {
            $query->where('city', $this->selectedCity);
        }
        
        // Apply quick filters (matching ProfileList logic)
        if ($this->ageGroup) {
            $this->applyAgeGroupFilter($query, $this->ageGroup);
        }

        if ($this->sortRecommendation) {
            // Sort by: 1) VIP status, 2) average rating, 3) newest
            $sortDirection = $this->sortRecommendation === 'desc' ? 'desc' : 'asc';
            $reverseSortDirection = $this->sortRecommendation === 'desc' ? 'asc' : 'desc';
            
            $query->withAvg('ratings', 'rating')
                  ->withExists('activeSubscription as is_vip')
                  ->orderBy('is_vip', $sortDirection)
                  ->orderBy('ratings_avg_rating', $sortDirection)
                  ->orderBy('created_at', $reverseSortDirection);
        }

        if ($this->hasVerifiedPhoto) {
            $query->whereNotNull('verified_at');
        }

        if ($this->hasVideo) {
            // Filter profiles that have video media in their profile-images collection
            $query->whereHas('media', function($q) {
                $q->where('collection_name', 'profile-images')
                  ->where('mime_type', 'like', 'video/%');
            });
        }

        if ($this->isPornActress) {
            $query->where('is_porn_actress', true);
        }

        if ($this->sortNew) {
            // Sort by created_at (newest/oldest)
            $query->orderBy('created_at', $this->sortNew === 'desc' ? 'desc' : 'asc');
        }

        if ($this->hasRating) {
            // Filter profiles that have at least one rating and order by most rated (rating count)
            $query->withCount('ratings')
                  ->whereHas('ratings')
                  ->orderBy('ratings_count', 'desc');
        }

        return $query->paginate($this->perPage);
    }
    
    /**
     * Apply age group filter logic (matching ProfileList)
     */
    private function applyAgeGroupFilter($query, $ageGroup)
    {
        switch ($ageGroup) {
            case '18-25':
                $query->whereBetween('age', [18, 25]);
                break;
            case '26-30':
                $query->whereBetween('age', [26, 30]);
                break;
            case '31-35':
                $query->whereBetween('age', [31, 35]);
                break;
            case '36-40':
                $query->whereBetween('age', [36, 40]);
                break;
            case '40-50':
                $query->whereBetween('age', [40, 50]);
                break;
            case '50+':
                $query->where('age', '>=', 50);
                break;
        }
    }


    public function getSelectedCountryProperty()
    {
        if (!$this->selectedCountryCode) {
            return null;
        }
        $codes = include base_path('lang/en/codes.php');
        return (object) [
            'country_code' => $this->selectedCountryCode,
            'country_name' => $codes[strtolower($this->selectedCountryCode)] ?? $this->selectedCountryCode,
        ];
    }

    public function render()
    {
        return view('livewire.country-profiles', [
            'countries' => $this->countries,
            'profiles' => $this->profiles,
            'selectedCountry' => $this->selectedCountry,
        ]);
    }
}
