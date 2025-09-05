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
        $womanRole = Role::firstOrCreate(['name' => 'woman']);
        $manRole = Role::firstOrCreate(['name' => 'man']);

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

        // Woman permissions
        $womanRole->givePermissionTo([
            'view_profile',
            'create_profile',
            'update_profile',
            'delete_profile',
        ]);

        // Man permissions (read-only public profiles)
        $manRole->givePermissionTo([
            'view_profile',
        ]);

        // Create admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->syncRoles(['admin']);

        // Create a simple example profile for the admin
        if (!$admin->profile) {
            Profile::create([
                'user_id' => $admin->id,
                'display_name' => 'Admin Profile',
                'age' => 30,
                'city' => 'Admin City',
                'address' => '1 Admin Street',
                'about' => 'This is the admin profile.',
                'availability_hours' => [
                    'Monday' => '9:00-17:00',
                ],
                'status' => 'approved',
                'is_public' => true,
                'verified_at' => now(),
            ]);
        }

        // Create a woman user (no profile)
        $woman = User::firstOrCreate([
            'email' => 'woman@example.com'
        ], [
            'name' => 'Jane Doe',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'gender' => 'female',
            'email_verified_at' => now(),
        ]);
        $woman->syncRoles(['woman']);

        // Create a man user (no profile)
        $man = User::firstOrCreate([
            'email' => 'man@example.com'
        ], [
            'name' => 'John Smith',
            'password' => Hash::make('password'),
            'phone' => '+0987654321',
            'gender' => 'male',
            'email_verified_at' => now(),
        ]);
        $man->syncRoles(['man']);
    }
}
