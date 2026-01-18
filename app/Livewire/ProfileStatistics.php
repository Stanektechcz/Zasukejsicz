<?php

namespace App\Livewire;

use App\Models\Profile;
use App\Models\ProfileView;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\Attributes\Computed;

class ProfileStatistics extends Component
{
    public ?Profile $profile = null;
    public Carbon $currentMonth;
    
    // Chart data for both types
    public array $clickChartData = [];
    public array $impressionChartData = [];
    public array $chartLabels = [];
    
    // Summary stats
    public int $totalClicks = 0;
    public int $totalImpressions = 0;
    public int $monthlyClicks = 0;
    public int $monthlyImpressions = 0;

    public function mount()
    {
        $user = auth()->user();
        
        if ($user) {
            // Load profile - admins can also be female and have profiles
            $user->load('profile');
            
            if ($user->profile) {
                $this->profile = $user->profile;
            }
        }
        
        $this->currentMonth = now()->startOfMonth();
        $this->loadStatistics();
    }

    public function loadStatistics(): void
    {
        if (!$this->profile) {
            return;
        }

        $startDate = $this->currentMonth->copy()->startOfMonth();
        $endDate = $this->currentMonth->copy()->endOfMonth();
        
        // Get daily stats for both types
        $clickStats = ProfileView::getDailyStats(
            $this->profile->id,
            $startDate->toDateString(),
            $endDate->toDateString(),
            ProfileView::TYPE_CLICK
        );
        
        $impressionStats = ProfileView::getDailyStats(
            $this->profile->id,
            $startDate->toDateString(),
            $endDate->toDateString(),
            ProfileView::TYPE_IMPRESSION
        );

        // Build chart data for each day of the month
        $this->chartLabels = [];
        $this->clickChartData = [];
        $this->impressionChartData = [];
        
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->toDateString();
            $label = $currentDate->format('j. n.');
            
            $this->chartLabels[] = $label;
            $this->clickChartData[] = $clickStats[$dateStr] ?? 0;
            $this->impressionChartData[] = $impressionStats[$dateStr] ?? 0;
            
            $currentDate->addDay();
        }

        // Calculate summary stats
        $this->totalClicks = ProfileView::getTotalStats($this->profile->id, ProfileView::TYPE_CLICK);
        $this->totalImpressions = ProfileView::getTotalStats($this->profile->id, ProfileView::TYPE_IMPRESSION);
        
        // Monthly stats
        $this->monthlyClicks = ProfileView::where('profile_id', $this->profile->id)
            ->where('type', ProfileView::TYPE_CLICK)
            ->whereBetween('viewed_date', [$startDate, $endDate])
            ->count();
            
        $this->monthlyImpressions = ProfileView::where('profile_id', $this->profile->id)
            ->where('type', ProfileView::TYPE_IMPRESSION)
            ->whereBetween('viewed_date', [$startDate, $endDate])
            ->count();
    }

    public function previousMonth(): void
    {
        $this->currentMonth = $this->currentMonth->copy()->subMonth();
        $this->loadStatistics();
    }

    public function nextMonth(): void
    {
        // Don't allow going beyond current month
        if ($this->canGoNext()) {
            $this->currentMonth = $this->currentMonth->copy()->addMonth();
            $this->loadStatistics();
        }
    }

    #[Computed]
    public function formattedMonth(): string
    {
        return $this->currentMonth->translatedFormat('F Y');
    }

    #[Computed]
    public function canGoNext(): bool
    {
        return $this->currentMonth->copy()->addMonth()->startOfMonth() <= now()->startOfMonth();
    }

    public function render()
    {
        return view('livewire.profile-statistics');
    }
}
