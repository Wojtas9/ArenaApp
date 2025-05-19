<?php

namespace App\Http\Controllers;

use App\Models\TrainingProgram;
use App\Models\Spot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingProgramsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = TrainingProgram::with('coach')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('training-programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $spots = Spot::all();
        
        return view('training-programs.create', compact('spots'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,completed,cancelled',
            'todo_list' => 'nullable|string', // Change from 'json' to 'string'
        ]);
        
        // Decode the JSON string to an array before saving
        $todoList = $request->todo_list ? json_decode($request->todo_list, true) : [];
        
        $program = TrainingProgram::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'coach_id' => Auth::id(),
            'todo_list' => $todoList, // Use the decoded array
        ]);
        
        return redirect()->route('training-programs.show', $program)
            ->with('success', 'Training program created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingProgram $trainingProgram)
    {
        $trainingProgram->load(['coach']);
        
        return view('training-programs.show', compact('trainingProgram'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingProgram $trainingProgram)
    {
        $spots = Spot::all();
        
        return view('training-programs.edit', compact('trainingProgram', 'spots'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrainingProgram $trainingProgram)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,completed,cancelled',
            'todo_list' => 'nullable|string', // Change from 'json' to 'string'
        ]);
        
        // Decode the JSON string to an array before saving
        $todoList = $request->todo_list ? json_decode($request->todo_list, true) : [];
        
        $trainingProgram->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'todo_list' => $todoList, // Use the decoded array
        ]);
        
        return redirect()->route('training-programs.show', $trainingProgram)
            ->with('success', 'Training program updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingProgram $trainingProgram)
    {
        $trainingProgram->delete();
        
        return redirect()->route('training-programs.index')
            ->with('success', 'Training program deleted successfully!');
    }
    
}