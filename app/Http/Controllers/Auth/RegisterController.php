<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,coach,player'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Assign Spatie role
        $user->assignRole($request->role);
        
        // Check if user is blocked before login (unlikely for new registrations, but added for completeness)
        if ($user->is_blocked) {
            return redirect()->route('login')
                ->with('error', 'Your account has been blocked. Please contact the administrator.');
        }


        Auth::login($user);

        // Redirect based on user role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isCoach()) {
            return redirect()->route('coach.dashboard');
        } else {
            return redirect()->route('player.dashboard');
        }
    }
}