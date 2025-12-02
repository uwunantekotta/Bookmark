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
            'role' => 'required|in:admin,contributor,viewer',
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:64|confirmed',
        ]);

        // Prevent user from changing their own role
        if (auth()->user()->id === $user->id && $request->role !== $user->role) {
            return back()->withErrors(['role' => 'You cannot change your own role']);
        }

        $update = [
            'name' => $request->name,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $update['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($update);

        return back()->with('success', 'User updated successfully');
    }

    /**
     * Ban a user
     */
    public function ban(Request $request, User $user)
    {
        if (auth()->user()->id === $user->id) {
            return back()->withErrors(['error' => 'You cannot ban yourself']);
        }

        $request->validate([
            'banned_reason' => 'nullable|string|max:500'
        ]);

        $user->update([
            'banned' => true,
            'banned_reason' => $request->banned_reason,
        ]);

        return back()->with('success', 'User has been banned');
    }

    /**
     * Unban a user
     */
    public function unban(User $user)
    {
        $user->update([
            'banned' => false,
            'banned_reason' => null,
        ]);

        return back()->with('success', 'User has been unbanned');
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
