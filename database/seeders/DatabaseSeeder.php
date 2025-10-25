<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create permissions if they don't exist
        $permissions = [
            'view_user',
            'view_any_user',
            'create_user',
            'update_user',
            'delete_user',
            'restore_user',
            'force_delete_user',
            'view_profile',
            'view_any_profile',
            'create_profile',
            'update_profile',
            'delete_profile',
            'restore_profile',
            'force_delete_profile',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());

        // User permissions
        $userRole->givePermissionTo([
            'view_profile',
            'create_profile',
            'update_profile',
            'delete_profile',
        ]);

        // Create admin user
        $admin = User::firstOrCreate([
            'email' => 'test@example.com'
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');
        


        // Create a woman user with profile
        $woman = User::firstOrCreate([
            'email' => 'woman@example.com'
        ], [
            'name' => 'Jane Doe',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'email_verified_at' => now(),
        ]);
        $woman->syncRoles(['user']);
        
        if (!$woman->profile) {
            Profile::create([
                'user_id' => $woman->id,
                'gender' => 'female',
                'display_name' => 'Jane Professional Massage',
                'age' => 28,
                'city' => 'New York',
                'address' => '123 Wellness Street',
                'about' => 'Professional massage therapist with 5+ years of experience. Specializing in relaxation and therapeutic massage.',
                'availability_hours' => [
                    'Monday' => '9:00-17:00',
                    'Tuesday' => '9:00-17:00',
                    'Wednesday' => '9:00-17:00',
                    'Thursday' => '9:00-17:00',
                    'Friday' => '9:00-17:00',
                ],
                'status' => 'approved',
                'is_public' => true,
                'verified_at' => now(),
            ]);
        }

        // Create a man user with profile
        $man = User::firstOrCreate([
            'email' => 'user@example.com'
        ], [
            'name' => 'John Smith',
            'password' => Hash::make('password'),
            'phone' => '+0987654321',
            'email_verified_at' => now(),
        ]);
        $man->syncRoles(['user']);
        
        if (!$man->profile) {
            Profile::create([
                'user_id' => $man->id,
                'gender' => 'male',
                'display_name' => 'John Professional Massage',
                'age' => 35,
                'city' => 'Chicago',
                'address' => '456 Health Avenue',
                'about' => 'Experienced male massage therapist specializing in sports and deep tissue massage.',
                'availability_hours' => [
                    'Tuesday' => '10:00-18:00',
                    'Thursday' => '10:00-18:00',
                    'Saturday' => '9:00-15:00',
                ],
                'status' => 'approved',
                'is_public' => true,
                'verified_at' => now(),
            ]);
        }

        // Create 5 demo users with profiles
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix'];
        $profileData = [
            ['name' => 'Sarah Johnson', 'gender' => 'female'],
            ['name' => 'Emma Wilson', 'gender' => 'female'],
            ['name' => 'Lisa Brown', 'gender' => 'female'],
            ['name' => 'Michael Garcia', 'gender' => 'male'],
            ['name' => 'David Davis', 'gender' => 'male'],
        ];
        
        foreach ($profileData as $index => $data) {
            $email = 'demo' . ($index + 1) . '@example.com';
            $demoUser = User::firstOrCreate([
                'email' => $email
            ], [
                'name' => $data['name'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $demoUser->syncRoles(['user']);
            
            if (!$demoUser->profile) {
                Profile::create([
                    'user_id' => $demoUser->id,
                    'gender' => $data['gender'],
                    'display_name' => $data['name'] . ' Massage Therapy',
                    'age' => rand(23, 45),
                    'city' => $cities[array_rand($cities)],
                    'address' => (rand(100, 999)) . ' Health Ave',
                    'about' => 'Experienced massage therapist offering relaxing and therapeutic treatments.',
                    'availability_hours' => [
                        'Monday' => '10:00-18:00',
                        'Wednesday' => '10:00-18:00',
                        'Friday' => '10:00-18:00',
                    ],
                    'status' => 'approved',
                    'is_public' => true,
                    'verified_at' => rand(0, 1) ? now() : null,
                ]);
            }
        }
    }
}
