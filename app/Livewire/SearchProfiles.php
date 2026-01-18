<?php

namespace App\Livewire;

use App\Models\Profile;
use Livewire\Component;

class SearchProfiles extends Component
{
    // Search filters
    public $city = '';
    public $age_range = '';

    // UI state
    public $showCityDropdown = false;
    public $showAgeRangeDropdown = false;

    public function mount()
    {
        $this->city = request('city', '');
        $this->age_range = request('age', '');
    }

    /**
     * Get all available cities from approved, public, and verified profiles
     * Similar to CountryProfiles implementation
     */
    public function getAllCitiesProperty()
    {
        return Profile::query()
            ->where('status', 'approved')
            ->where('is_public', true)
            ->whereNotNull('verified_at')
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->pluck('city')
            ->sort()
            ->values()
            ->toArray();
    }

    public function updatedCity()
    {
        $this->showCityDropdown = true;
    }

    public function selectCity($city)
    {
        $this->city = $city;
        $this->showCityDropdown = false;
    }

    public function showDropdown()
    {
        $this->showCityDropdown = true;
    }

    public function clearAndShowDropdown()
    {
        $this->city = '';
        $this->showCityDropdown = true;
    }

    // Age Range methods
    public function clearAndShowAgeRangeDropdown()
    {
        $this->age_range = '';
        $this->showAgeRangeDropdown = true;
    }

    public function selectAgeRange($ageRange)
    {
        $this->age_range = $ageRange;
        $this->showAgeRangeDropdown = false;
    }

    public function getFilteredCitiesProperty()
    {
        $cities = $this->allCities;
        
        if (empty($this->city)) {
            return $cities;
        }

        return collect($cities)
            ->filter(fn($cityOption) => str_contains(strtolower($cityOption), strtolower($this->city)))
            ->values()
            ->toArray();
    }

    public function getAgeRangeOptionsProperty()
    {
        return [
            '18-25' => '18-25 yo',
            '26-30' => '26-30 yo',
            '31-35' => '31-35 yo',
            '36-40' => '36-40 yo',
            '40-50' => '40-50 yo',
            '50+' => '50 yo +',
        ];
    }

    /**
     * Execute search - redirect to countries page with filters
     */
    public function search()
    {
        $params = [];
        
        if ($this->city) {
            $params['city'] = $this->city;
        }
        
        if ($this->age_range) {
            $params['age'] = $this->age_range;
        }

        return $this->redirect(route('countries.index', $params));
    }

    public function render()
    {
        return view('livewire.search-profiles');
    }
}
