<div wire:poll.5s="loadStatistics">
    @if($profile)

        <!-- Profile Clicks Chart Section -->
        <div class="mb-28">
            <h2 class="text-2xl font-bold text-secondary mb-4">
                {{ __('front.account.statistics.profile_views_title') }}
            </h2>
            <div>
                <canvas 
                    id="clicksChart" 
                    height="80"
                    wire:ignore
                ></canvas>
            </div>
            
            <!-- Month Navigation for Clicks -->
            <div class="flex items-center justify-center gap-4 mt-6">
                <div class="flex-1 h-px bg-gray-300"></div>
                
                <button 
                    type="button" 
                    wire:click="previousMonth"
                    class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center hover:shadow-lg transition-all duration-200 cursor-pointer"
                >
                    ⏴
                </button>
                
                <div class="text-lg font-semibold text-gray-900 min-w-[150px] text-center">
                    {{ $this->formattedMonth }}
                </div>
                
                <button 
                    type="button" 
                    wire:click="nextMonth"
                    class="w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-200 cursor-pointer {{ $this->canGoNext() ? 'bg-primary text-white hover:shadow-lg' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                    @if(!$this->canGoNext()) disabled @endif
                >
                    ⏵
                </button>
                
                <div class="flex-1 h-px bg-gray-300"></div>
            </div>
        </div>

        <!-- Listing Impressions Chart Section -->
        <div class="mb-20">
            <h2 class="text-2xl font-bold text-secondary mb-4">
                {{ __('front.account.statistics.listing_views_title') }}
            </h2>
            <div>
                <canvas 
                    id="impressionsChart" 
                    height="80"
                    wire:ignore
                ></canvas>
            </div>
            
            <!-- Month Navigation for Impressions -->
            <div class="flex items-center justify-center gap-4 mt-6">
                <div class="flex-1 h-px bg-gray-300"></div>
                
                <button 
                    type="button" 
                    wire:click="previousMonth"
                    class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center hover:shadow-lg transition-all duration-200 cursor-pointer"
                >
                    ⏴
                </button>
                
                <div class="text-lg font-semibold text-gray-900 min-w-[150px] text-center">
                    {{ $this->formattedMonth }}
                </div>
                
                <button 
                    type="button" 
                    wire:click="nextMonth"
                    class="w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-200 cursor-pointer {{ $this->canGoNext() ? 'bg-primary text-white hover:shadow-lg' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                    @if(!$this->canGoNext()) disabled @endif
                >
                    ⏵
                </button>
                
                <div class="flex-1 h-px bg-gray-300"></div>
            </div>
        </div>

        <!-- VIP Badge (if applicable) -->
        @if($profile->isVip())
            <div class="flex justify-center mt-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-400 text-white rounded-full font-semibold">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    VIP
                </div>
            </div>
        @endif
    @else
        <!-- No Profile Message -->
        <div class="text-center py-12">
            <div class="text-gray-500 text-lg">
                {{ __('front.account.statistics.no_profile') }}
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    let clicksChart = null;
    let impressionsChart = null;

    function createChart(canvasId, labels, data, color, label) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return null;

        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: color,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                animation: {
                    duration: 750,
                    easing: 'easeInOutQuart'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        titleColor: '#F9FAFB',
                        bodyColor: '#F9FAFB',
                        borderColor: '#374151',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10,
                            font: {
                                size: 12,
                                family: "'Inter', sans-serif"
                            },
                            color: '#6B7280'
                        },
                        grid: {
                            color: '#E5E7EB',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 11,
                                family: "'Inter', sans-serif"
                            },
                            color: '#6B7280',
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    function updateCharts(labels, clickData, impressionData) {
        // Update existing charts if they exist, otherwise create them
        if (clicksChart) {
            clicksChart.data.labels = labels;
            clicksChart.data.datasets[0].data = clickData;
            clicksChart.update('none'); // Update without animation
        } else {
            clicksChart = createChart(
                'clicksChart', 
                labels, 
                clickData, 
                '#EC4899', 
                '{{ __('front.account.statistics.profile_clicks') }}'
            );
        }
        
        if (impressionsChart) {
            impressionsChart.data.labels = labels;
            impressionsChart.data.datasets[0].data = impressionData;
            impressionsChart.update('none'); // Update without animation
        } else {
            impressionsChart = createChart(
                'impressionsChart', 
                labels, 
                impressionData, 
                '#7C3AED', 
                '{{ __('front.account.statistics.listing_impressions') }}'
            );
        }
    }

    // Initialize charts on page load
    document.addEventListener('DOMContentLoaded', function() {
        const labels = @json($chartLabels);
        const clickData = @json($clickChartData);
        const impressionData = @json($impressionChartData);
        updateCharts(labels, clickData, impressionData);
    });

    // Update charts when Livewire updates
    document.addEventListener('livewire:initialized', () => {
        Livewire.hook('morph.updated', ({ component }) => {
            setTimeout(() => {
                const labels = @this.chartLabels;
                const clickData = @this.clickChartData;
                const impressionData = @this.impressionChartData;
                updateCharts(labels, clickData, impressionData);
            }, 50);
        });
    });
</script>
@endpush
