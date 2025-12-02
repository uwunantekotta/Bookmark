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
        $search = $request->input('q'); // Get search query

        // Helper to map data
        $mapItem = function ($item, $type) use ($userId) {
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
                'my_rating' => $userRating ? $userRating->rating : 0,
            ];
        };

        $ratingQuery = function($q) use ($userId) {
            $q->where('user_id', $userId);
        };

        // --- Fetch Bookmarks ---
        $bookmarksQuery = Bookmark::with(['user', 'ratings' => $ratingQuery])
            ->whereNotNull('uploaded_at');

        if ($search) {
            $bookmarksQuery->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('artist', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%");
            });
        }

        $bookmarks = $bookmarksQuery->get()->map(fn($b) => $mapItem($b, 'bookmark'));

        // --- Fetch Approved Music ---
        $musicQuery = Music::with(['user', 'ratings' => $ratingQuery])
            ->where('status', Music::STATUS_APPROVED)
            ->whereNotNull('uploaded_at');

        if ($search) {
            $musicQuery->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('artist', 'like', "%{$search}%");
            });
        }

        $musics = $musicQuery->get()->map(fn($m) => $mapItem($m, 'music'));

        // Merge, Sort, Paginate
        $items = $bookmarks->merge($musics)->sortByDesc(fn($item) => $item->uploaded_at ?? now())->values();

        $page = max(1, (int) $request->get('page', 1));
        $perPage = 12;
        $total = $items->count();
        $slice = $items->slice(($page - 1) * $perPage, $perPage)->values();

        $posts = new LengthAwarePaginator(
            $slice, $total, $perPage, $page, ['path' => route('feed'), 'query' => $request->query()]
        );

        return view('feed', ['posts' => $posts]);
    }
}