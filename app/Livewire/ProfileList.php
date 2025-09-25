<?php

namespace App\Livewire;

use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ProfileList extends Component
{
    use WithPagination;

    public $loading = false;
    public $perPage = 12;
    
    // Current filters (synced with search component)
    public $city = '';
    public $ageMin = '';
    public $ageMax = '';
    public $verified = false;
    
    protected $queryString = [
        'city' => ['except' => ''],
        'ageMin' => ['except' => '', 'as' => 'age_min'],
        'ageMax' => ['except' => '', 'as' => 'age_max'],
        'verified' => ['except' => false],
    ];

    public function mount()
    {
        // Set filters from URL parameters
        $this->city = request('city', '');
        $this->ageMin = request('age_min', '');
        $this->ageMax = request('age_max', '');
        $this->verified = request()->boolean('verified');
    }

    /**
     * Listen for search updates from the search component
     */
    #[On('profile-search-updated')]
    public function updateFilters($filters)
    {
        $this->city = $filters['city'] ?? '';
        $this->ageMin = $filters['age_min'] ?? '';
        $this->ageMax = $filters['age_max'] ?? '';
        $this->verified = $filters['verified'] ?? false;
        
        // Reset pagination
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 12;
    }

    public function resetFilters()
    {
        $this->reset(['city', 'ageMin', 'ageMax', 'verified']);
        $this->resetPage();
    }

    public function getProfilesProperty()
    {
        $query = Profile::with(['user:id,name', 'media'])
            ->approved()
            ->public()
            ->select($this->getPublicProfileColumns())
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($this->city) {
            $query->where('city', 'like', '%' . $this->city . '%');
        }

        if ($this->ageMin) {
            $query->where('age', '>=', $this->ageMin);
        }

        if ($this->ageMax) {
            $query->where('age', '<=', $this->ageMax);
        }

        if ($this->verified) {
            $query->verified();
        }

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.profile-list', [
            'profiles' => $this->profiles
        ]);
    }

    /**
     * Get only necessary columns for public profile view
     */
    private function getPublicProfileColumns(): array
    {
        return [
            'id',
            'user_id',
            'display_name',
            'gender',
            'age', 
            'city',
            'about',
            'verified_at',
            'status',
            'created_at',
            'updated_at'
        ];
    }
}