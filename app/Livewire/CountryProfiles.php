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

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // Set the first country as default or leave null for all countries
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

    public function getCountriesProperty()
    {
        $codes = include base_path('lang/en/codes.php');
        $profiles = Profile::query()
            ->where('is_public', true)
            ->whereNotNull('country_code')
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
        $query = Profile::query()
            ->where('status', 'approved')
            ->where('is_public', true)
            ->whereNotNull('verified_at');

        if ($this->selectedCountryCode) {
            $query->where('country_code', $this->selectedCountryCode);
        }

        if ($this->selectedCity) {
            $query->where('city', $this->selectedCity);
        }

        return $query->latest()
            ->paginate($this->perPage);
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
