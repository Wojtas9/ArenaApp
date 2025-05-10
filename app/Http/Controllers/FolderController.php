<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $folders = Folder::where('user_id', Auth::id())->get();
        return view('folders.index', compact('folders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('folders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $folder = new Folder();
        $folder->name = $validated['name'];
        $folder->description = $validated['description'] ?? null;
        $folder->user_id = Auth::id();
        $folder->save();

        return redirect()->route('folders.index')->with('success', 'Folder created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder)
    {
        // Check if the folder belongs to the authenticated user
        if ($folder->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('folders.show', compact('folder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Folder $folder)
    {
        // Check if the folder belongs to the authenticated user
        if ($folder->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('folders.edit', compact('folder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Folder $folder)
    {
        // Check if the folder belongs to the authenticated user
        if ($folder->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $folder->name = $validated['name'];
        $folder->description = $validated['description'] ?? null;
        $folder->save();

        return redirect()->route('folders.index')->with('success', 'Folder updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Folder $folder)
    {
        // Check if the folder belongs to the authenticated user
        if ($folder->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $folder->delete();

        return redirect()->route('folders.index')->with('success', 'Folder deleted successfully.');
    }
}