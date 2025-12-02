<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // ... [index method remains same] ...
    public function index()
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('bookmarks', compact('bookmarks'));
    }

    // Public Page
    public function showWelcome(Request $request)
    {
        // Viewers are not allowed on this page, redirect to feed
        if (Auth::check() && Auth::user()->role === 'viewer') {
            return redirect()->route('feed');
        }

        // ... [Rest of logic remains same] ...
        $query = Bookmark::with('user');

        if ($request->filled('genre')) {
            $query->where('genre', 'like', '%' . $request->genre . '%');
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('artist', 'like', "%{$q}%")
                    ->orWhere('title', 'like', "%{$q}%");
            });
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $allowedSorts = ['artist','title','genre','rating_avg','reviews_count','views','created_at'];
        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'created_at';
        
        $order = $request->get('order', 'desc');
        $order = strtolower($order) === 'asc' ? 'asc' : 'desc';

        $bookmarks = $query->orderBy($sortBy, $order)->paginate(20)->withQueryString();
        
        $genres = Bookmark::select('genre')->whereNotNull('genre')->distinct()->pluck('genre');

        return view('welcome_clean', compact('bookmarks', 'genres'));
    }

    // ... [Rest of Controller logic matches existing file] ...
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'artist' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
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

        return redirect()->route('welcome_clean')->with('success', 'Bookmark saved!');
    }

    public function destroy($id)
    {
        $bookmark = Bookmark::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($bookmark->image) {
            Storage::disk('public')->delete($bookmark->image);
        }

        $bookmark->delete();

        return redirect()->route('welcome_clean')->with('success', 'Bookmark deleted.');
    }
}