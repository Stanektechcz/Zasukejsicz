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
    public $allCities = [];

    public function mount()
    {
        $this->city = request('city', '');
        $this->age_range = request('age', '');

        $this->loadCities();
    }

    public function loadCities()
    {
        $this->allCities = Profile::approved()
            ->public()
            ->whereNotNull('city')
            ->pluck('city')
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    public function updatedCity()
    {
        $this->showCityDropdown = !empty($this->city);
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
        if (empty($this->city)) {
            return $this->allCities;
        }

        return collect($this->allCities)
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
