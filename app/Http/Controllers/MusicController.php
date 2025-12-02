<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;
use Illuminate\Support\Facades\Auth;

class MusicController extends Controller
{
    public function index() {
        $musics = Music::where('user_id', Auth::id())->latest()->get();
        return view('music.index', compact('musics'));
    }

    public function store(Request $request) {
        $request->validate([
            'artist' => 'required|string|max:255',
            'url' => 'required|url',
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('music', 'public');
        }

        Music::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'url' => $request->url,
            'image_path' => $path,
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Music bookmark saved!');
    }
}
