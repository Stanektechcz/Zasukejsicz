<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class CountryProfiles extends Component
{
    use WithPagination;

    public $selectedCountryId = null;
    public $selectedCity = null;
    public $expandedCountries = [];
    public $perPage = 20;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // Set the first country as default or leave null for all countries
    }

    public function selectCountry($countryId = null)
    {
        $this->selectedCountryId = $countryId;
        $this->selectedCity = null; // Reset city when changing country
        $this->resetPage();
    }

    public function selectCity($countryId, $city = null)
    {
        $this->selectedCountryId = $countryId;
        $this->selectedCity = $city;
        $this->resetPage();
    }

    public function toggleCountryExpansion($countryId)
    {
        if (in_array($countryId, $this->expandedCountries)) {
            $this->expandedCountries = array_diff($this->expandedCountries, [$countryId]);
        } else {
            $this->expandedCountries[] = $countryId;
        }
    }

    public function loadMore()
    {
        $this->perPage += 20;
    }

    public function getCountriesProperty()
    {
        return Country::orderBy('country_name')
            ->withCount('profiles')
            ->get()
            ->map(function ($country) {
                // Get cities for this country with profile counts
                $cities = Profile::where('country_id', $country->id)
                    ->where('status', 'approved')
                    ->where('is_public', true)
                    ->whereNotNull('verified_at')
                    ->whereNotNull('city')
                    ->select('city', DB::raw('count(*) as profiles_count'))
                    ->groupBy('city')
                    ->orderBy('city')
                    ->get();
                    
                $country->cities = $cities;
                return $country;
            });
    }

    public function getProfilesProperty()
    {
        $query = Profile::query()
            ->where('status', 'approved')
            ->where('is_public', true)
            ->whereNotNull('verified_at');

        if ($this->selectedCountryId) {
            $query->where('country_id', $this->selectedCountryId);
        }

        if ($this->selectedCity) {
            $query->where('city', $this->selectedCity);
        }

        return $query->latest()
            ->paginate($this->perPage);
    }

    public function getSelectedCountryProperty()
    {
        if (!$this->selectedCountryId) {
            return null;
        }

        return Country::find($this->selectedCountryId);
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
