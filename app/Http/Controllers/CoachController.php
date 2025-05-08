<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoachController extends Controller
{
    /**
     * Display the coach dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('dashboard.coach');
    }
}