<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Music;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'type' => 'required|in:bookmark,music',
            'id' => 'required|integer',
        ]);

        // 1. Determine Model
        $modelClass = $data['type'] === 'bookmark' ? Bookmark::class : Music::class;
        $item = $modelClass::findOrFail($data['id']);

        // 2. Create or Update Rating
        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'rateable_id' => $item->id,
                'rateable_type' => $modelClass,
            ],
            ['rating' => $data['rating']]
        );

        // 3. Recalculate Averages
        $newAvg = $item->ratings()->avg('rating');
        $newCount = $item->ratings()->count();

        $item->update([
            'rating_avg' => $newAvg,
            'reviews_count' => $newCount
        ]);

        return back()->with('success', 'Rating submitted!');
    }
}