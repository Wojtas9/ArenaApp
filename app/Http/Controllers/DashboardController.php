<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('dashboard.player');
    }
}