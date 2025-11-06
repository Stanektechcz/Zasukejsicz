<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;

class CountryProfiles extends Component
{
    use WithPagination;

    public $selectedCountryId = null;
    public $perPage = 20;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // Set the first country as default or leave null for all countries
    }

    public function selectCountry($countryId = null)
    {
        $this->selectedCountryId = $countryId;
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 20;
    }

    public function getCountriesProperty()
    {
        return Country::orderBy('country_name')
            ->withCount('profiles')
            ->get();
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
