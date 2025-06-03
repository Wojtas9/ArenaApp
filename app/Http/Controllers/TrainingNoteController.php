<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingNote;
use Illuminate\Support\Facades\Auth;

class TrainingNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainingNotes = TrainingNote::where('user_id', Auth::id())->latest()->paginate(10); // Change 10 to your desired number of items per page
        return view('training-notes.index', compact('trainingNotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('training-notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'training_date' => 'required|date',
            'duration' => 'nullable|integer',
            'intensity' => 'nullable|string|max:50',
            'exercises' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        $validated['user_id'] = Auth::id();
        
        TrainingNote::create($validated);
        
        return redirect()->route('training-notes.index')
            ->with('success', 'Training note created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingNote  $trainingNote
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingNote $trainingNote)
    {
        if ($trainingNote->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('training-notes.show', compact('trainingNote'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingNote  $trainingNote
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingNote $trainingNote)
    {
        if ($trainingNote->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('training-notes.edit', compact('trainingNote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrainingNote  $trainingNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingNote $trainingNote)
    {
        if ($trainingNote->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'training_date' => 'required|date',
            'duration' => 'nullable|integer',
            'intensity' => 'nullable|string|max:50',
            'description' => 'nullable|string', 
            'exercises' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        $trainingNote->update($validated);
        
        return redirect()->route('training-notes.index')
            ->with('success', 'Training note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingNote  $trainingNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingNote $trainingNote)
    {
        if ($trainingNote->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $trainingNote->delete();
        
        return redirect()->route('training-notes.index')
            ->with('success', 'Training note deleted successfully.');
    }
}
