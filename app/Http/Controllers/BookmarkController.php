<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // Show full bookmarks list (bookmarks.blade.php) - Restricted to logged in user's own list
    public function index()
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('bookmarks', compact('bookmarks'));
    }

    // Show public bookmarks list on welcome_clean page (RIGHT COLUMN)
    public function showWelcome(Request $request)
    {
        // Eager load the author for the public list
        $query = Bookmark::with('user');

        // Optionally filter by genre
        if ($request->filled('genre')) {
            $query->where('genre', 'like', '%' . $request->genre . '%');
        }

        // Optionally search by artist/title
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('artist', 'like', "%{$q}%")
                    ->orWhere('title', 'like', "%{$q}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $order = $request->get('order', 'desc');

        $allowedSorts = ['artist','title','genre','rating_avg','reviews_count','views','created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        $order = strtolower($order) === 'asc' ? 'asc' : 'desc';

        $bookmarks = $query->orderBy($sortBy, $order)->paginate(20)->withQueryString();

        $genres = Bookmark::select('genre')->whereNotNull('genre')->distinct()->pluck('genre');

        return view('welcome_clean', compact('bookmarks', 'genres'));
    }

    // Save bookmark
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'artist' => 'required|string',
            'url' => 'required|url',
            'image' => 'nullable|image|max:2048',
            'release_date' => 'nullable|date'
        ]);

        $data['user_id'] = Auth::id();

        // Upload image if provided
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('bookmarks', 'public');
        }

        // Set uploaded_at to now
        $data['uploaded_at'] = now();

        Bookmark::create($data);

        // --- CHANGE HERE ---
        // Instead of return back(), we force a redirect to the welcome_clean route.
        return redirect()->route('welcome_clean')->with('success', 'Bookmark saved!');
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

        // Redirect explicitly here as well to be safe
        return redirect()->route('welcome_clean')->with('success', 'Bookmark deleted.');
    }
}