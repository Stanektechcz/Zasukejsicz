<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * Controller for male user (member) account features.
 * Male users have different features than female users who manage profiles.
 */
class MemberController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Show the member dashboard (user settings).
     */
    public function dashboard()
    {
        $user = Auth::user();
        $user->load(['roles', 'permissions']);
        
        return view('member.dashboard', compact('user'));
    }

    /**
     * Show the ratings page.
     * TODO: Implement ratings functionality for male users.
     */
    public function ratings()
    {
        $user = Auth::user();
        
        return view('member.ratings', compact('user'));
    }

    /**
     * Show the favorites page.
     */
    public function favorites()
    {
        $user = Auth::user();
        $favorites = $user->favoriteProfiles()
            ->approved()
            ->public()
            ->with(['media'])
            ->latest('profile_favorites.created_at')
            ->paginate(12);
        
        return view('member.favorites', compact('user', 'favorites'));
    }

    /**
     * Remove a profile from favorites.
     */
    public function removeFavorite(\App\Models\Profile $profile)
    {
        $user = Auth::user();
        $user->favoriteProfiles()->detach($profile->id);
        
        return redirect()->route('account.member.favorites')
            ->with('status', __('front.favorites.removed'));
    }

    /**
     * Show the girls of the month page.
     * TODO: Implement girls of the month functionality.
     */
    public function girlsOfMonth()
    {
        $user = Auth::user();
        
        return view('member.girls-of-month', compact('user'));
    }

    /**
     * Show the girls archive page.
     * TODO: Implement archive functionality.
     */
    public function archive()
    {
        $user = Auth::user();
        
        return view('member.archive', compact('user'));
    }

    /**
     * Show the reported girls page.
     * TODO: Implement reported girls functionality.
     */
    public function reported()
    {
        $user = Auth::user();
        
        return view('member.reported', compact('user'));
    }

    /**
     * Update user settings.
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone,' . $user->id],
        ]);

        $user->fill($request->only(['name', 'email', 'phone']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('account.member.dashboard')->with('status', 'settings-updated');
    }

    /**
     * Show the password change form.
     */
    public function showPasswordForm()
    {
        return view('member.password.edit');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('account.member.dashboard')->with('status', 'password-updated');
    }
}
