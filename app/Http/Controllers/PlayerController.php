<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingNote;
use App\Models\Message;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    // Player Dashboard
    public function dashboard()
    {
        $userId = Auth::id();
        
        // Get counts for Quick Stats section
        $stats = [
            'trainingNotes' => TrainingNote::where('user_id', $userId)->count(),
            'coaches' => User::where('role', 'coach')->count(), 
            'messages' => Message::where('recipient_id', $userId)->count(),
            'events' => Event::where('instructor_id', $userId)->count()
        ];
        
        return view('dashboard.player', compact('stats'));
    }
}