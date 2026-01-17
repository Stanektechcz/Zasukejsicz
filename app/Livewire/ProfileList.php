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
    public $perPage = 20;
    
    // Current filters (synced with search component)
    public $city = '';
    public $ageMin = '';
    public $ageMax = '';
    public $verified = false;
    
    // Quick filter properties
    public $ageGroup = ''; // '18-25', '26-30', '31-35', '36-40', '40-50', '50+'
    public $sortRecommendation = ''; // '', 'desc' (best first), 'asc' (worst first)
    public $hasVerifiedPhoto = false;
    public $hasVideo = false;
    public $isPornActress = false;
    public $sortNew = ''; // '', 'desc' (newest first), 'asc' (oldest first)
    public $hasRating = false; // profiles with rating/reviews
    
    protected $queryString = [
        'city' => ['except' => ''],
        'ageMin' => ['except' => '', 'as' => 'age_min'],
        'ageMax' => ['except' => '', 'as' => 'age_max'],
        'verified' => ['except' => false],
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
        // Set filters from URL parameters
        $this->city = request('city', '');
        $this->ageMin = request('age_min', '');
        $this->ageMax = request('age_max', '');
        $this->verified = request()->boolean('verified');
        
        // Set quick filters from URL
        $this->ageGroup = request('age', '');
        $this->sortRecommendation = request('recommend', '');
        $this->hasVerifiedPhoto = request()->boolean('verified_photo');
        $this->hasVideo = request()->boolean('video');
        $this->isPornActress = request()->boolean('actress');
        $this->sortNew = request('new', '');
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
        $this->perPage += 10;
    }

    public function resetFilters()
    {
        $this->reset(['city', 'ageMin', 'ageMax', 'verified', 'ageGroup', 'sortRecommendation', 'hasVerifiedPhoto', 'hasVideo', 'isPornActress', 'sortNew', 'hasRating']);
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
    #[Computed]
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
            $query->verified();
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