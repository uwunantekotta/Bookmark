<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller
{
    /**
     * Show all users for management
     */
    public function index()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user edit form
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,contributor,viewer'
        ]);

        // Prevent user from changing their own role
        if (auth()->user()->id === $user->id) {
            return back()->withErrors(['role' => 'You cannot change your own role']);
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', 'User role updated successfully');
    }

    /**
     * Delete a user
     */
    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if (auth()->user()->id === $user->id) {
            return back()->withErrors(['error' => 'You cannot delete your own account']);
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully');
    }
}
