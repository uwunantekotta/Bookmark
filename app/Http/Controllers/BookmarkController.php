<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Storage;

class BookmarkController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $bookmarks = Bookmark::where('user_id', $user->id)->orderByDesc('created_at')->get();
        return response()->json($bookmarks);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'title' => ['nullable','string','max:255'],
            'url' => ['required','url'],
            'tags' => ['nullable','array'],
            'image' => ['nullable','image','max:2048'],
        ]);

        $bookmarkData = [
            'user_id' => $user->id,
            'title' => $data['title'] ?? null,
            'url' => $data['url'],
            'tags' => $data['tags'] ?? [],
        ];

        // handle image upload if provided
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('bookmarks', 'public');
            $bookmarkData['image'] = $path;
        }

        $bookmark = Bookmark::create($bookmarkData);

        return response()->json($bookmark, 201);
    }

    public function update(Request $request, Bookmark $bookmark)
    {
        $user = $request->user();
        if ($bookmark->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'title' => ['nullable','string','max:255'],
            'url' => ['required','url'],
            'tags' => ['nullable','array'],
            'image' => ['nullable','image','max:2048'],
        ]);

        $update = [
            'title' => $data['title'] ?? null,
            'url' => $data['url'],
            'tags' => $data['tags'] ?? [],
        ];

        if ($request->hasFile('image')) {
            // delete old image if present
            if ($bookmark->image) {
                try { Storage::disk('public')->delete($bookmark->image); } catch (\Exception $e) { /* ignore */ }
            }
            $update['image'] = $request->file('image')->store('bookmarks', 'public');
        }

        $bookmark->update($update);

        return response()->json($bookmark);
    }

    public function destroy(Request $request, Bookmark $bookmark)
    {
        $user = $request->user();
        if ($bookmark->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        // delete stored image if present
        if ($bookmark->image) {
            try { Storage::disk('public')->delete($bookmark->image); } catch (\Exception $e) { /* ignore */ }
        }
        $bookmark->delete();
        return response()->json(['deleted' => true]);
    }

    public function clearAll(Request $request)
    {
        $user = $request->user();
        Bookmark::where('user_id', $user->id)->delete();
        return response()->json(['cleared' => true]);
    }

    public function import(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'bookmarks' => ['required','array'],
        ]);

        $created = [];
        foreach ($data['bookmarks'] as $b) {
            if (!isset($b['url'])) continue;
            $created[] = Bookmark::create([
                'user_id' => $user->id,
                'title' => $b['title'] ?? null,
                'url' => $b['url'],
                'tags' => $b['tags'] ?? [],
            ]);
        }

        return response()->json(['imported' => count($created)]);
    }

    public function export(Request $request)
    {
        $user = $request->user();
        $bookmarks = Bookmark::where('user_id', $user->id)->orderByDesc('created_at')->get();
        return response()->json($bookmarks);
    }
}


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())->latest()->get();
        return response()->json($bookmarks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'artist' => 'required|string|max:255',
            'url' => 'required|url',
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('title', 'url');
        $data['user_id'] = Auth::id();
        $data['tags'] = [$request->artist];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('bookmarks', 'public');
        }

        $bookmark = Bookmark::create($data);

        return response()->json($bookmark);
    }

    public function destroy($id)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())->findOrFail($id);
        $bookmark->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
