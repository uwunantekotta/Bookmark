<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;
use App\Models\Bookmark;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class PostManagementController extends Controller
{
    /**
     * Show all posts (Pending Music + All Published Content)
     */
    public function index(Request $request)
    {
        // 1. Fetch Pending Music (Needs separate attention)
        $pendingMusic = Music::where('status', Music::STATUS_PENDING)
            ->with('user')
            ->latest()
            ->get();

        // 2. Fetch Approved/Published Music
        $musicPosts = Music::where('status', Music::STATUS_APPROVED) // Only show approved in the main feed
            ->with('user')
            ->get()
            ->map(function ($music) {
                $music->type = 'music';
                return $music;
            });

        // 3. Fetch All Bookmarks (They are always "published")
        $bookmarkPosts = Bookmark::with('user')
            ->get()
            ->map(function ($bookmark) {
                $bookmark->type = 'bookmark';
                return $bookmark;
            });

        // 4. Merge and Sort
        $allPosts = $musicPosts->merge($bookmarkPosts)->sortByDesc('uploaded_at');

        // 5. Paginate Manually
        $page = max(1, (int) $request->get('page', 1));
        $perPage = 15;
        $total = $allPosts->count();
        $items = $allPosts->slice(($page - 1) * $perPage, $perPage)->values();

        $posts = new LengthAwarePaginator(
            $items, 
            $total, 
            $perPage, 
            $page, 
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.posts.index', compact('pendingMusic', 'posts'));
    }

    /**
     * Approve Music
     */
    public function approveMusic(Music $music)
    {
        $music->update([
            'status' => Music::STATUS_APPROVED,
            'rejection_reason' => null
        ]);

        return back()->with('success', 'Music approved successfully');
    }

    /**
     * Reject Music
     */
    public function rejectMusic(Request $request, Music $music)
    {
        $request->validate(['rejection_reason' => 'nullable|string|max:255']);

        $music->update([
            'status' => Music::STATUS_REJECTED,
            'rejection_reason' => $request->rejection_reason
        ]);

        return back()->with('success', 'Music rejected successfully');
    }

    /**
     * Delete a Post (Music or Bookmark)
     */
    public function destroy($type, $id)
    {
        if ($type === 'music') {
            $post = Music::findOrFail($id);
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
        } elseif ($type === 'bookmark') {
            $post = Bookmark::findOrFail($id);
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        } else {
            return back()->withErrors(['error' => 'Invalid post type']);
        }

        $post->delete();

        return back()->with('success', ucfirst($type) . ' deleted successfully');
    }
}