<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class SpotController extends Controller
{
    /**
     * Display a listing of the spots.
     */
    public function index()
    {
        $spots = Spot::all();
        return view('spots.index', compact('spots'));
    }

    /**
     * Show the form for creating a new spot.
     */
    public function create()
    {
        return view('spots.create');
    }

    /**
     * Store a newly created spot in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'description' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/spots'), $imageName);
            $validatedData['picture'] = 'images/spots/' . $imageName;
        }

        Spot::create($validatedData);

        return redirect()->route('spots.index')->with('success', 'Spot created successfully');
    }

    /**
     * Display the specified spot.
     */
    public function show(Spot $spot)
    {
        return view('spots.show', compact('spot'));
    }

    /**
     * Show the form for editing the specified spot.
     */
    public function edit(Spot $spot)
    {
        return view('spots.edit', compact('spot'));
    }

    /**
     * Update the specified spot in storage.
     */
    public function update(Request $request, Spot $spot)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'description' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            // Delete old image if exists
            if ($spot->picture && file_exists(public_path($spot->picture))) {
                unlink(public_path($spot->picture));
            }
            
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/spots'), $imageName);
            $validatedData['picture'] = 'images/spots/' . $imageName;
        }

        $spot->update($validatedData);

        return redirect()->route('spots.index')->with('success', 'Spot updated successfully');
    }

    /**
     * Remove the specified spot from storage.
     */
    public function destroy($id)
    {
        // Find the spot
        $spot = Spot::findOrFail($id);
        
        // Delete the spot
        $spot->delete();
        
        // Redirect to index with success message
        return redirect()->route('spots.index')->with('success', 'Spot deleted successfully');
    }
}