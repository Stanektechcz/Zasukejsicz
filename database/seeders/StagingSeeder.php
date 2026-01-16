<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Service;
use App\Models\Rating;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class StagingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder creates comprehensive test data for staging environments:
     * - Multiple users with profiles
     * - Profile images from placeholder services
     * - Attached services
     * - Ratings and reviews
     * 
     * Usage: php artisan db:seed --class=StagingSeeder
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting staging data seeding...');
        
        // Ensure roles exist
        $this->ensureRolesExist();
        
        // Ensure services exist
        $this->ensureServicesExist();
        
        // Create admin user if doesn't exist
        $this->createAdminUser();
        
        // Get count from container or use default
        $count = app()->bound('staging.user.count') ? app('staging.user.count') : 20;
        
        // Create regular users with profiles
        $this->createUsersWithProfiles($count);
        
        // Seed pages (blog posts, FAQ, etc.)
        $this->seedPages();
        
        $this->command->info('✅ Staging data seeding completed!');
    }
    
    /**
     * Seed pages using PageSeeder
     */
    private function seedPages(): void
    {
        if (\App\Models\Page::count() === 0) {
            $this->call(PageSeeder::class);
        } else {
            $this->command->info('✓ Pages already exist, skipping');
        }
    }
    
    /**
     * Ensure roles exist
     */
    private function ensureRolesExist(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);
        
        $this->command->info('✓ Roles verified');
    }
    
    /**
     * Ensure services exist
     */
    private function ensureServicesExist(): void
    {
        if (Service::count() === 0) {
            $this->call(ServicesSeeder::class);
        }
        
        $this->command->info('✓ Services verified');
    }
    
    /**
     * Create admin user
     */
    private function createAdminUser(): void
    {
        $adminEmail = 'admin@example.com';
        
        if (!User::where('email', $adminEmail)->exists()) {
            $admin = User::create([
                'name' => 'Admin User',
                'email' => $adminEmail,
                'phone' => '+420 123 456 789',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]);
            
            $admin->assignRole('admin');
            
            $this->command->info("✓ Admin user created (email: {$adminEmail}, password: password)");
        } else {
            $this->command->info('✓ Admin user already exists');
        }
    }
    
    /**
     * Create regular users with profiles
     */
    private function createUsersWithProfiles(int $count): void
    {
        $this->command->info("Creating {$count} users with profiles...");
        $progressBar = $this->command->getOutput()->createProgressBar($count);
        
        $services = Service::where('is_active', true)->pluck('id')->toArray();
        
        for ($i = 0; $i < $count; $i++) {
            // Create user
            $user = User::factory()->create();
            $user->assignRole('user');
            
            // Create profile for user
            $profile = Profile::factory()
                ->for($user)
                ->create();
            
            // Randomly set some profiles as approved and public (for frontend testing)
            if (fake()->boolean(70)) {
                $profile->status = 'approved';
                $profile->is_public = true;
                $profile->save();
            }
            
            // Attach random services (3-10 services per profile)
            $randomServices = fake()->randomElements($services, fake()->numberBetween(3, min(10, count($services))));
            $profile->services()->attach($randomServices);
            
            // Add profile images (2-6 images per profile)
            $this->addProfileImages($profile, fake()->numberBetween(2, 6));
            
            // Add some ratings (for approved profiles)
            if ($profile->status === 'approved') {
                $this->addRatings($profile, fake()->numberBetween(0, 8));
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->command->newLine();
        $this->command->info("✓ Created {$count} users with profiles");
    }
    
    /**
     * Add profile images from placeholder services
     */
    private function addProfileImages(Profile $profile, int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            try {
                // Use different placeholder services
                $imageUrl = $this->getRandomPlaceholderImage($i);
                
                // Download and attach image
                $profile->addMediaFromUrl($imageUrl)
                    ->toMediaCollection('profile-images');
                    
            } catch (\Exception $e) {
                // If image download fails, try alternative method
                try {
                    $this->addFallbackImage($profile, $i);
                } catch (\Exception $fallbackException) {
                    // Silently continue if both methods fail
                    continue;
                }
            }
        }
    }
    
    /**
     * Get random placeholder image URL
     */
    private function getRandomPlaceholderImage(int $seed): string
    {
        // Use Lorem Picsum for reliable placeholder images
        // Adding random seed ensures different images each time
        $randomSeed = $seed . '-' . uniqid();
        
        return "https://picsum.photos/seed/{$randomSeed}/800/600";
    }
    
    /**
     * Add fallback image using local generation
     */
    private function addFallbackImage(Profile $profile, int $index): void
    {
        // Use picsum with different dimensions as fallback
        $randomSeed = 'fallback-' . $index . '-' . uniqid();
        $url = "https://picsum.photos/seed/{$randomSeed}/800/600";
        
        $profile->addMediaFromUrl($url)
            ->toMediaCollection('profile-images');
    }
    
    /**
     * Add ratings to profile
     */
    private function addRatings(Profile $profile, int $count): void
    {
        if ($count === 0) {
            return;
        }
        
        // Get some random users to rate this profile
        $ratingUsers = User::where('id', '!=', $profile->user_id)
            ->inRandomOrder()
            ->limit($count)
            ->get();
        
        foreach ($ratingUsers as $ratingUser) {
            Rating::create([
                'profile_id' => $profile->id,
                'user_id' => $ratingUser->id,
                'rating' => fake()->numberBetween(3, 5), // Mostly positive ratings (3-5 stars)
            ]);
        }
    }
}
