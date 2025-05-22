<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoachProfile;
use App\Models\User;
use App\Models\Spot;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CoachProfileController extends Controller
{
    /**
     * Display a listing of coach profiles.
     */
    public function index()
    {
        $coachProfiles = CoachProfile::all();
        return view('coach-profiles.index', compact('coachProfiles'));
    }

    /**
     * Show the form for creating a new coach profile.
     */
    public function create()
    {
        return view('coach-profiles.edit');
    }

    /**
     * Store a newly created coach profile.
     */
    public function store(Request $request)
    {
        return $this->updateOrCreate($request);
    }

    /**
     * Display the specified coach profile.
     */
    public function show($coachProfile)
    {
        // Find the coach by ID
        $coach = User::where('role', 'coach')->findOrFail($coachProfile);

        // Load the coach profile relationship if it exists
        $coach->load('coachProfile');

        // Pass the coach variable to the view
        return view('coach-profiles.show', compact('coach'));
    }

    /**
     * Show the form for editing the specified coach profile.
     */
    public function edit(CoachProfile $profile)
    {
        $spots = Spot::all(); 
        return view('coach-profiles.edit', compact('profile', 'spots'));
    }

    /**
     * Update the specified coach profile.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:1000',
            'specialty' => 'nullable|string|max:255',
            'favorite_halls' => 'nullable|string',
            'accessibility' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $coachProfile = CoachProfile::updateOrCreate(
            ['user_id' => $id],
            [
                'description' => $validated['description'] ?? null,
                'specialty' => $validated['specialty'] ?? null,
                'favorite_halls' => $validated['favorite_halls'] ?? null,
                'accessibility' => $validated['accessibility'] ?? null,
            ]
        );

        if ($request->hasFile('photo')) {
            if ($coachProfile->photo) {
                Storage::delete('public/' . $coachProfile->photo);
            }
            $path = $request->file('photo')->store('coach-profiles', 'public');
            $coachProfile->photo = $path;
            $coachProfile->save();
        }

        return redirect()->route('coach-profiles.show', $id)
            ->with('success', 'Coach profile updated successfully');
    }

    private function updateOrCreate(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'specialty' => 'nullable|string|max:255',
            'favorite_halls' => 'nullable|string',
            'accessibility' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $coachProfile = CoachProfile::where('user_id', Auth::id())->first();
        if (!$coachProfile) {
            $coachProfile = new CoachProfile();
            $coachProfile->user_id = Auth::id();
        }

        // Map the validated data to the database fields
        $coachProfile->description = $validated['description'] ?? null;
        $coachProfile->specialty = $validated['specialty'] ?? null;
        $coachProfile->favorite_halls = $validated['favorite_halls'] ?? null;
        $coachProfile->accessibility = $validated['accessibility'] ?? null;

        if ($request->hasFile('photo')) {
            if ($coachProfile->photo) {
                Storage::delete('public/' . $coachProfile->photo);
            }
            $path = $request->file('photo')->store('coach-profiles', 'public');
            $coachProfile->photo = $path;
        }

        $coachProfile->save();

        return redirect()->route('coach-profiles.show', ['id' => $coachProfile->id])
            ->with('success', 'Coach profile updated successfully');
    }

    /**
     * Display a listing of all coach profiles for searching.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        // Get all users with the coach role who have profiles
        $coaches = User::role('coach')
            ->with('coachProfile')
            ->whereHas('coachProfile')
            ->get();
        
        return view('coach-profiles.search', compact('coaches'));
    }
}