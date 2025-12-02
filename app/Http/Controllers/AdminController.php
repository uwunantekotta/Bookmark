<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Music;
use App\Models\Bookmark; // Imported Bookmark model

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalMusic = Music::count();
        $totalBookmarks = Bookmark::count();
        
        // Calculate total posts (Music + Bookmarks)
        $totalPosts = $totalMusic + $totalBookmarks;

        // Removed pending/approved/rejected logic
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalMusic',
            'totalPosts'
        ));
    }
}