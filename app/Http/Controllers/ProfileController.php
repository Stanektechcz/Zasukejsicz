<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display a listing of public profiles.
     */
    public function index(Request $request): View
    {
        $query = Profile::with('user')
            ->approved()
            ->public()
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('age_min')) {
            $query->where('age', '>=', $request->age_min);
        }

        if ($request->filled('age_max')) {
            $query->where('age', '<=', $request->age_max);
        }

        if ($request->boolean('verified')) {
            $query->verified();
        }

        $profiles = $query->paginate(12);

        // Get unique cities for filter dropdown
        $cities = Profile::approved()
            ->public()
            ->whereNotNull('city')
            ->pluck('city')
            ->unique()
            ->sort()
            ->values();

        return view('profiles.index', compact('profiles', 'cities'));
    }
}
