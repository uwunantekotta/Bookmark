<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Music;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalMusic = Music::count();
        $pendingMusic = Music::where('status', 'pending')->count();
        $approvedMusic = Music::where('status', 'approved')->count();
        $rejectedMusic = Music::where('status', 'rejected')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalMusic',
            'pendingMusic',
            'approvedMusic',
            'rejectedMusic'
        ));
    }
}
