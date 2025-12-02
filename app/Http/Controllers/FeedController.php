<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Music;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Helper to map data and include user's specific rating
        $mapItem = function ($item, $type) use ($userId) {
            // Find if current user rated this item
            $userRating = $item->ratings->firstWhere('user_id', $userId);

            return (object) [
                'id' => $item->id,
                'type' => $type,
                'title' => $item->title,
                'artist' => $item->artist,
                'url' => $item->url,
                'image' => $type === 'music' ? $item->image_path : $item->image,
                'user' => $item->user,
                'uploaded_at' => $item->uploaded_at,
                'release_date' => $item->release_date,
                'genre' => $item->genre ?? null,
                'rating_avg' => $item->rating_avg ?? 0,
                'reviews_count' => $item->reviews_count ?? 0,
                'views' => $item->views ?? 0,
                'status' => $item->status ?? null,
                'my_rating' => $userRating ? $userRating->rating : 0, // <--- Added this
            ];
        };

        // Eager load 'ratings' for the current user only to save performance
        $ratingQuery = function($q) use ($userId) {
            $q->where('user_id', $userId);
        };

        // Fetch Bookmarks
        $bookmarks = Bookmark::with(['user', 'ratings' => $ratingQuery])
            ->whereNotNull('uploaded_at')
            ->get()
            ->map(fn($b) => $mapItem($b, 'bookmark'));

        // Fetch Approved Music
        $musics = Music::with(['user', 'ratings' => $ratingQuery])
            ->where('status', Music::STATUS_APPROVED)
            ->whereNotNull('uploaded_at')
            ->get()
            ->map(fn($m) => $mapItem($m, 'music'));

        // Merge, Sort, Paginate
        $items = $bookmarks->merge($musics)->sortByDesc(fn($item) => $item->uploaded_at ?? now())->values();

        $page = max(1, (int) $request->get('page', 1));
        $perPage = 12;
        $total = $items->count();
        $slice = $items->slice(($page - 1) * $perPage, $perPage)->values(); // use slice() on collection, not forPage()

        $posts = new LengthAwarePaginator(
            $slice, $total, $perPage, $page, ['path' => route('feed')]
        );

        return view('feed', ['posts' => $posts]);
    }
}