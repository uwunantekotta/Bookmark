<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // Show full bookmarks list (bookmarks.blade.php)
    public function index()
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('bookmarks', compact('bookmarks'));
    }

    // Show bookmarks on welcome_clean page (RIGHT COLUMN)
    public function showWelcome()
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('welcome_clean', compact('bookmarks'));
    }

    // Save bookmark
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'artist' => 'required|string',
            'url' => 'required|url',
            'image' => 'nullable|image|max:2048'
        ]);

        $data['user_id'] = Auth::id();

        // Upload image if provided
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('bookmarks', 'public');
        }

        Bookmark::create($data);

        return back()->with('success', 'Bookmark saved!');
    }

    // Optional: delete a bookmark
    public function destroy($id)
    {
        $bookmark = Bookmark::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Delete image if exists
        if ($bookmark->image) {
            Storage::disk('public')->delete($bookmark->image);
        }

        $bookmark->delete();

        return back()->with('success', 'Bookmark deleted.');
    }
}
