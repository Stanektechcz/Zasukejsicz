// Global Profile Store for Alpine.js
document.addEventListener('alpine:init', () => {
    Alpine.store('profiles', {
        // State
        data: [],
        loading: false,
        error: null,
        pagination: {
            current_page: 1,
            last_page: 1,
            per_page: 12,
            total: 0,
            has_more: false
        },
        filters: {
            city: '',
            age_min: '',
            age_max: '',
            verified: false
        },
        cities: [],

        // Actions
        async fetchProfiles(page = 1, append = false) {
            this.loading = true;
            this.error = null;

            try {
                const url = new URL('/api/profiles', window.location.origin);
                
                // Add filters to URL
                Object.keys(this.filters).forEach(key => {
                    if (this.filters[key] && this.filters[key] !== '') {
                        url.searchParams.set(key, this.filters[key]);
                    }
                });
                
                url.searchParams.set('page', page);
                url.searchParams.set('per_page', this.pagination.per_page);

                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();

                if (result.success) {
                    // Either append for infinite scroll or replace for new search
                    this.data = append ? [...this.data, ...result.data] : result.data;
                    this.pagination = result.pagination;
                    this.cities = result.filters.cities;
                } else {
                    throw new Error('API returned error');
                }
            } catch (error) {
                console.error('Error fetching profiles:', error);
                this.error = 'Failed to load profiles. Please try again.';
            } finally {
                this.loading = false;
            }
        },

        async loadMore() {
            if (this.pagination.has_more && !this.loading) {
                await this.fetchProfiles(this.pagination.current_page + 1, true);
            }
        },

        async search(newFilters = {}) {
            // Update filters
            this.filters = { ...this.filters, ...newFilters };
            
            // Reset pagination and fetch new results
            this.pagination.current_page = 1;
            await this.fetchProfiles(1, false);
        },

        resetFilters() {
            this.filters = {
                city: '',
                age_min: '',
                age_max: '',
                verified: false
            };
            this.fetchProfiles(1, false);
        },

        getProfile(id) {
            return this.data.find(profile => profile.id === id);
        },

        // Computed getters
        get hasProfiles() {
            return this.data.length > 0;
        },

        get isEmpty() {
            return !this.loading && this.data.length === 0;
        },

        get canLoadMore() {
            return this.pagination.has_more && !this.loading;
        }
    });
});

// Alpine.js component for profile list
document.addEventListener('alpine:init', () => {
    Alpine.data('profileList', () => ({
        init() {
            // Initialize with current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const filters = {
                city: urlParams.get('city') || '',
                age_min: urlParams.get('age_min') || '',
                age_max: urlParams.get('age_max') || '',
                verified: urlParams.get('verified') === '1'
            };
            
            this.$store.profiles.filters = filters;
            this.$store.profiles.fetchProfiles();
        },

        loadMore() {
            this.$store.profiles.loadMore();
        },

        search(filters) {
            this.$store.profiles.search(filters);
            this.updateUrl();
        },

        updateUrl() {
            const url = new URL(window.location);
            const filters = this.$store.profiles.filters;
            
            // Clear existing params
            url.searchParams.delete('city');
            url.searchParams.delete('age_min');
            url.searchParams.delete('age_max');
            url.searchParams.delete('verified');
            
            // Add non-empty filters
            Object.keys(filters).forEach(key => {
                if (filters[key] && filters[key] !== '') {
                    url.searchParams.set(key, filters[key]);
                }
            });
            
            // Update URL without page reload
            window.history.pushState({}, '', url);
        }
    }));
});

// Alpine.js component for search functionality
document.addEventListener('alpine:init', () => {
    Alpine.data('profileSearch', () => ({
        filters: {
            city: '',
            age_min: '',
            age_max: '',
            verified: false
        },
        
        cities: [],
        filteredCities: [],
        showCityDropdown: false,

        init() {
            // Get initial values from URL or store
            this.filters = { ...this.$store.profiles.filters };
            this.cities = this.$store.profiles.cities;
            this.filteredCities = this.cities;
        },

        filterCities() {
            if (this.filters.city.length === 0) {
                this.filteredCities = this.cities;
            } else {
                this.filteredCities = this.cities.filter(city => 
                    city.toLowerCase().includes(this.filters.city.toLowerCase())
                );
            }
            this.showCityDropdown = true;
        },

        selectCity(city) {
            this.filters.city = city;
            this.showCityDropdown = false;
        },

        handleSearch() {
            // Trigger search through the store
            this.$store.profiles.search(this.filters);
            
            // Update URL
            const url = new URL(window.location.origin + '/');
            Object.keys(this.filters).forEach(key => {
                if (this.filters[key] && this.filters[key] !== '') {
                    url.searchParams.set(key, this.filters[key]);
                }
            });
            
            // Navigate to search results
            window.location.href = url.toString();
        }
    }));
});
