<?php

namespace App\Livewire;

use App\Models\Profile;
use Livewire\Component;

class SearchProfiles extends Component
{
    // Search filters
    public $city = '';
    public $age_min = '';
    public $age_max = '';
    
    // UI state
    public $showCityDropdown = false;
    public $showAgeMinDropdown = false;
    public $showAgeMaxDropdown = false;
    public $allCities = [];
    
    public function mount()
    {
        $this->city = request('city', '');
        $this->age_min = request('age_min', '');
        $this->age_max = request('age_max', '');
        
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
    
    // Age Min methods
    public function clearAndShowAgeMinDropdown()
    {
        $this->age_min = '';
        $this->showAgeMinDropdown = true;
    }
    
    public function selectAgeMin($age)
    {
        $this->age_min = $age;
        $this->showAgeMinDropdown = false;
    }
    
    // Age Max methods
    public function clearAndShowAgeMaxDropdown()
    {
        $this->age_max = '';
        $this->showAgeMaxDropdown = true;
    }
    
    public function selectAgeMax($age)
    {
        $this->age_max = $age;
        $this->showAgeMaxDropdown = false;
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
    
    public function getAgeMinOptionsProperty()
    {
        $options = [];
        for ($age = 20; $age <= 60; $age += 5) {
            $options[$age] = $age . ' ' . __('years');
        }
        return $options;
    }
    
    public function getAgeMaxOptionsProperty()
    {
        $options = [];
        for ($age = 25; $age <= 65; $age += 5) {
            $options[$age] = $age . ' ' . __('years');
        }
        return $options;
    }
    
    /**
     * Execute search - emit event to update profile list
     */
    public function search()
    {
        $filters = array_filter([
            'city' => $this->city,
            'age_min' => $this->age_min,
            'age_max' => $this->age_max,
        ]);
        
        // Emit event to profile list component
        $this->dispatch('profile-search-updated', $filters);
    }
    
    public function render()
    {
        return view('livewire.search-profiles');
    }
}
