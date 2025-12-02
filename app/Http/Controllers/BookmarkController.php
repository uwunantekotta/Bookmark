<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // Private Dashboard (User's personal list)
    public function index()
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('bookmarks', compact('bookmarks'));
    }

    // Public Page (The one with the form and list on the right)
    public function showWelcome(Request $request)
    {
        // 1. Load bookmarks with the user who created them
        $query = Bookmark::with('user');

        // 2. Filter by Genre
        if ($request->filled('genre')) {
            $query->where('genre', 'like', '%' . $request->genre . '%');
        }

        // 3. Search by Text
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('artist', 'like', "%{$q}%")
                    ->orWhere('title', 'like', "%{$q}%");
            });
        }

        // 4. Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $allowedSorts = ['artist','title','genre','rating_avg','reviews_count','views','created_at'];
        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'created_at';
        
        $order = $request->get('order', 'desc');
        $order = strtolower($order) === 'asc' ? 'asc' : 'desc';

        $bookmarks = $query->orderBy($sortBy, $order)->paginate(20)->withQueryString();
        $genres = Bookmark::select('genre')->whereNotNull('genre')->distinct()->pluck('genre');

        return view('welcome_clean', compact('bookmarks', 'genres'));
    }

    // Save Logic
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
        $data['uploaded_at'] = now();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('bookmarks', 'public');
        }

        Bookmark::create($data);

        // --- CRITICAL FIX ---
        // Force redirect to the "welcome_clean" route
        return redirect()->route('welcome_clean')->with('success', 'Bookmark saved!');
    }

    // Delete Logic
    public function destroy($id)
    {
        $bookmark = Bookmark::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($bookmark->image) {
            Storage::disk('public')->delete($bookmark->image);
        }

        $bookmark->delete();

        // Redirect back to welcome_clean
        return redirect()->route('welcome_clean')->with('success', 'Bookmark deleted.');
    }
}