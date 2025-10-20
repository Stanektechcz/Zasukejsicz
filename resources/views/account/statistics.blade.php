@extends('layouts.account')

@section('title', __('front.account.statistics.page_title'))

@php
    $activeItem = 'statistics';
@endphp

@section('account-content')
    <div class="mb-8">
        <h1 class="text-4xl font-semibold text-secondary py-6 text-center">
            {{ __('front.account.statistics.page_title') }}
        </h1>
        <hr>
    </div>

    <!-- Statistics Content -->
    <div class="py-6">
        <!-- Chart Section -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                {{ __('front.account.statistics.profile_views_title') }}
            </h2>
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <canvas id="profileViewsChart" height="80"></canvas>
            </div>
        </div>

        <!-- Month Navigation -->
        <div class="flex items-center justify-center gap-4 mt-6">
            <button type="button" class="p-3 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            
            <div class="text-lg font-semibold text-gray-900">
                prosinec 2025
            </div>
            
            <button type="button" class="p-3 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- VIP Badge -->
        <div class="flex justify-center mt-6">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-400 text-white rounded-full font-semibold">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                VIP
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('profileViewsChart');
            
            // Sample data matching the image
            const data = {
                labels: [
                    '10. 9.', '11. 9.', '12. 9.', '13. 9.', '14. 9.', '15. 9.', '16. 9.', '17. 9.', '18. 9.',
                    '19. 9.', '20. 9.', '21. 9.', '22. 9.', '23. 9.', '24. 9.', '25. 9.'
                ],
                datasets: [{
                    label: 'Počet zobrazení',
                    data: [38, 42, 64, 60, 22, 38, 43, 64, 44, 68, 96, 104, 66, 84, 83, 36],
                    backgroundColor: function(context) {
                        const index = context.dataIndex;
                        // Pink for dates before 19.9, Purple for dates from 19.9 onwards
                        return index < 9 ? '#EC4899' : '#7C3AED';
                    },
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
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
                            callbacks: {
                                label: function(context) {
                                    return 'Zobrazení: ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 120,
                            ticks: {
                                stepSize: 20,
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
                                color: '#6B7280'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            };

            new Chart(ctx, config);
        });
    </script>
    @endpush
@endsection
