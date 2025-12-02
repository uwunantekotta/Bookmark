<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;

class MusicApprovalController extends Controller
{
    /**
     * Show all pending music for approval
     */
    public function index()
    {
        $pendingMusic = Music::where('status', 'pending')
            ->with('user')
            ->latest()
            ->paginate(15);

        $approvedMusic = Music::where('status', 'approved')
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('admin.music.index', compact('pendingMusic', 'approvedMusic'));
    }

    /**
     * Approve a song
     */
    public function approve(Music $music)
    {
        // Only pending music can be approved
        if (!$music->isPending()) {
            return back()->withErrors(['error' => 'This music cannot be approved']);
        }

        $music->update([
            'status' => Music::STATUS_APPROVED,
            'rejection_reason' => null
        ]);

        return back()->with('success', 'Music approved successfully');
    }

    /**
     * Reject a song (with optional reason)
     */
    public function reject(Request $request, Music $music)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500'
        ]);

        // Only pending music can be rejected
        if (!$music->isPending()) {
            return back()->withErrors(['error' => 'This music cannot be rejected']);
        }

        $music->update([
            'status' => Music::STATUS_REJECTED,
            'rejection_reason' => $request->rejection_reason
        ]);

        return back()->with('success', 'Music rejected successfully');
    }

    /**
     * View rejected music
     */
    public function rejectedList()
    {
        $rejectedMusic = Music::where('status', 'rejected')
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('admin.music.rejected', compact('rejectedMusic'));
    }
}
