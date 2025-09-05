<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProfilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->roles()->whereIn('name', ['admin', 'woman', 'man'])->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Profile $profile): bool
    {
        // Admin can view all profiles
        if ($user->roles()->where('name', 'admin')->exists()) {
            return true;
        }

        // Users can view their own profile
        if ($user->id === $profile->user_id) {
            return true;
        }

        // Men can view approved public profiles
        if ($user->roles()->where('name', 'man')->exists() && $profile->status === 'approved' && $profile->is_public) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only women can create profiles (and only one)
        return $user->roles()->where('name', 'woman')->exists() && !$user->profile;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Profile $profile): bool
    {
        // Admin can update any profile
        if ($user->roles()->where('name', 'admin')->exists()) {
            return true;
        }

        // Women can update their own profile
        if ($user->roles()->where('name', 'woman')->exists() && $user->id === $profile->user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Profile $profile): bool
    {
        // Admin can delete any profile
        if ($user->roles()->where('name', 'admin')->exists()) {
            return true;
        }

        // Women can delete their own profile
        if ($user->roles()->where('name', 'woman')->exists() && $user->id === $profile->user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Profile $profile): bool
    {
        return $user->roles()->where('name', 'admin')->exists();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Profile $profile): bool
    {
        return $user->roles()->where('name', 'admin')->exists();
    }

    /**
     * Determine whether the user can verify the model.
     */
    public function verify(User $user, Profile $profile): bool
    {
        return $user->roles()->where('name', 'admin')->exists();
    }

    /**
     * Determine whether the user can approve the model.
     */
    public function approve(User $user, Profile $profile): bool
    {
        return $user->roles()->where('name', 'admin')->exists();
    }
}
