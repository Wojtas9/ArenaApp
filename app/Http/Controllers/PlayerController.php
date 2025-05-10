<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display the player dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('dashboard.player');
    }
}