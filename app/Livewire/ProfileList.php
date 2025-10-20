<?php

namespace App\Livewire;

use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;

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
    
    // Quick filter properties
    public $ageGroup = ''; // '18-25', '26-30', '31-35', '36-40', '40-50', '50+'
    public $hasVerifiedPhoto = false;
    public $hasVideo = false;
    public $isPornActress = false;
    public $isNew = false; // profiles created in last 7 days
    public $hasRating = false; // profiles with rating/reviews
    
    protected $queryString = [
        'city' => ['except' => ''],
        'ageMin' => ['except' => '', 'as' => 'age_min'],
        'ageMax' => ['except' => '', 'as' => 'age_max'],
        'verified' => ['except' => false],
        'ageGroup' => ['except' => '', 'as' => 'age'],
        'hasVerifiedPhoto' => ['except' => false, 'as' => 'verified_photo'],
        'hasVideo' => ['except' => false, 'as' => 'video'],
        'isPornActress' => ['except' => false, 'as' => 'actress'],
        'isNew' => ['except' => false, 'as' => 'new'],
        'hasRating' => ['except' => false, 'as' => 'rated'],
    ];

    public function mount()
    {
        // Set filters from URL parameters
        $this->city = request('city', '');
        $this->ageMin = request('age_min', '');
        $this->ageMax = request('age_max', '');
        $this->verified = request()->boolean('verified');
        
        // Set quick filters from URL
        $this->ageGroup = request('age', '');
        $this->hasVerifiedPhoto = request()->boolean('verified_photo');
        $this->hasVideo = request()->boolean('video');
        $this->isPornActress = request()->boolean('actress');
        $this->isNew = request()->boolean('new');
        $this->hasRating = request()->boolean('rated');
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
        $this->reset(['city', 'ageMin', 'ageMax', 'verified', 'ageGroup', 'hasVerifiedPhoto', 'hasVideo', 'isPornActress', 'isNew', 'hasRating']);
        $this->resetPage();
    }

    /**
     * Toggle quick filter methods
     */
    public function toggleAgeGroup($group)
    {
        $this->ageGroup = $this->ageGroup === $group ? '' : $group;
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
        $this->isNew = !$this->isNew;
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
    #[Computed]
    public function activeFiltersCount()
    {
        $count = 0;
        if ($this->ageGroup) $count++;
        if ($this->hasVerifiedPhoto) $count++;
        if ($this->hasVideo) $count++;
        if ($this->isPornActress) $count++;
        if ($this->isNew) $count++;
        if ($this->hasRating) $count++;
        return $count;
    }

    #[Computed]
    public function profiles()
    {
        $query = Profile::with(['user:id,name', 'media'])
            ->approved()
            ->public()
            ->select($this->getPublicProfileColumns())
            ->orderBy('created_at', 'desc');

        // Apply search filters (from search component)
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

        // Apply quick filters
        if ($this->ageGroup) {
            $this->applyAgeGroupFilter($query, $this->ageGroup);
        }

        if ($this->hasVerifiedPhoto) {
            $query->verified();
        }

        if ($this->hasVideo) {
            // Assuming videos are stored as media with specific collection
            $query->whereHas('media', function($q) {
                $q->where('collection_name', 'videos');
            });
        }

        // if ($this->isPornActress) {
        //     // This could be a profile field or tag system
        //     $query->where('is_porn_actress', true);
        // }

        if ($this->isNew) {
            $query->where('created_at', '>=', now()->subDays(7));
        }

        if ($this->hasRating) {
            // Assuming there's a reviews/ratings relationship
            $query->whereHas('reviews');
        }

        return $query->paginate($this->perPage);
    }

    /**
     * Apply age group filter logic
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

    public function render()
    {
        return view('livewire.profile-list');
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