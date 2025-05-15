<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $roleStats = [
            'admin' => User::where('role', 'admin')->count(),
            'coach' => User::where('role', 'coach')->count(),
            'player' => User::where('role', 'player')->count(),
        ];
        
        return view('dashboard.admin', compact('roleStats'));
    }
    
    /**
     * Get all coaches for API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCoaches()
    {
        $coaches = User::where('role', 'coach')->get(['id', 'name']);
        return response()->json($coaches);
    }
    
    /**
     * Display a listing of users.
     *
     * @return \Illuminate\View\View
     */
    public function users()
    {
        $users = User::paginate(10);
        return view('dashboard.users.index', compact('users'));
    }
    
    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.users.edit', compact('user'));
    }
    
    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', 'in:admin,coach,player'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        // Update role using Spatie Permission
        $user->syncRoles([$request->role]);
        
        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }
    
    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'You cannot delete your own account');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }

    /**
     * Toggle user block status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent blocking yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'You cannot block your own account');
        }
        
        $user->is_blocked = !$user->is_blocked;
        $user->save();
        
        $message = $user->is_blocked ? 'User blocked successfully' : 'User unblocked successfully';
        return redirect()->route('admin.users')->with('success', $message);
    }
}