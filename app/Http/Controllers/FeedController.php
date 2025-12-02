<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Music;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FeedController extends Controller
{
    /**
     * Display a unified feed of bookmarks and music.
     */
    public function index(Request $request)
    {
        // Get recent bookmarks and music, eager-load uploader
        $bookmarks = Bookmark::with('user')
            ->whereNotNull('uploaded_at')
            ->get()
            ->map(function ($b) {
                return (object) [
                    'id' => $b->id,
                    'type' => 'bookmark',
                    'title' => $b->title,
                    'artist' => $b->artist,
                    'url' => $b->url,
                    'image' => $b->image,
                    'user' => $b->user,
                    'uploaded_at' => $b->uploaded_at,
                    'release_date' => $b->release_date ?? null,
                    'genre' => $b->genre ?? null,
                    'rating_avg' => $b->rating_avg ?? 0,
                    'reviews_count' => $b->reviews_count ?? 0,
                    'views' => $b->views ?? 0,
                ];
            });

        $musics = Music::with('user')
            ->whereNotNull('uploaded_at')
            ->get()
            ->map(function ($m) {
                return (object) [
                    'id' => $m->id,
                    'type' => 'music',
                    'title' => $m->title,
                    'artist' => $m->artist,
                    'url' => $m->url,
                    'image' => $m->image_path,
                    'user' => $m->user,
                    'uploaded_at' => $m->uploaded_at,
                    'release_date' => $m->release_date ?? null,
                    'genre' => null,
                    'rating_avg' => null,
                    'reviews_count' => null,
                    'views' => null,
                    'status' => $m->status ?? null,
                ];
            });

        // Merge and sort by uploaded_at descending
        $items = $bookmarks->merge($musics)->sortByDesc(function ($item) {
            return $item->uploaded_at ?? now();
        })->values();

        // Simple manual pagination
        $page = max(1, (int) $request->get('page', 1));
        $perPage = 12;
        $total = $items->count();
        $slice = $items->forPage($page, $perPage);

        $paginator = new LengthAwarePaginator(
            $slice->all(),
            $total,
            $perPage,
            $page,
            ['path' => route('feed')]
        );

        return view('feed', ['posts' => $paginator]);
    }
}
