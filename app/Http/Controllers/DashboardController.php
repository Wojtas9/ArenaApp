<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingNote;
use App\Models\Message;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Admin dashboard
     */
    public function adminDashboard()
    {
        return view('dashboard.admin');
    }

    /**
     * Coach dashboard
     */
    public function coachDashboard()
    {
        return view('dashboard.coach');
    }

    /**
     * Player dashboard
     */
    public function playerDashboard()
    {
        $userId = Auth::id();
        
        // Get counts for Quick Stats section
        $stats = [
            'trainingNotes' => TrainingNote::where('user_id', $userId)->count(),
            'trainers' => User::where('role', 'coach')->count(),
            'coaches' => User::where('role', 'coach')->count(), // Same as trainers in this context
            'messages' => Message::where('recipient_id', $userId)->count(),
            'events' => Event::where('instructor_id', $userId)->count()
        ];
        
        return view('dashboard.player', compact('stats'));
    }
}
