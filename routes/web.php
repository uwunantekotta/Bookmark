<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PostManagementController; // Changed from MusicApprovalController
use App\Http\Controllers\FeedController;

// ... [Previous Auth & Public Routes remain unchanged] ...

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/welcome_clean', [BookmarkController::class, 'showWelcome'])
    ->name('welcome_clean');

// Authentication Routes...
Route::get('/register', function () {
    if (Auth::check()) return redirect('/welcome_clean');
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'name' => ['required','string','max:255'],
        'email' => ['required','email','max:255','unique:users,email'],
        'password' => ['required','confirmed','min:8','max:64','regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};:\\|,.<>\/\?]).{8,64}$/'],
        'role' => ['required','in:admin,contributor,viewer'],
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => $data['role'] ?? 'viewer',
    ]);

    Auth::login($user);
    $request->session()->regenerate();
    return redirect('/welcome_clean');
});

Route::get('/login', function () {
    if (Auth::check()) return redirect('/welcome_clean');
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required','email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/welcome_clean');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('welcome');
})->name('logout');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/feed', [FeedController::class, 'index'])->name('feed');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{id}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::get('/music', [MusicController::class, 'index'])->name('music.index');
    Route::post('/music', [MusicController::class, 'store'])->name('music.store');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/banned', [UserManagementController::class, 'banned'])->name('banned');
        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{user}/role', [UserManagementController::class, 'updateRole'])->name('updateRole');
        Route::post('/{user}/ban', [UserManagementController::class, 'ban'])->name('ban');
        Route::post('/{user}/unban', [UserManagementController::class, 'unban'])->name('unban');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    // UPDATED: Post Management Routes (Replaces Music Approval)
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostManagementController::class, 'index'])->name('index');
        Route::post('/music/{music}/approve', [PostManagementController::class, 'approveMusic'])->name('approve');
        Route::post('/music/{music}/reject', [PostManagementController::class, 'rejectMusic'])->name('reject');
        // Generic delete route for any post type
        Route::delete('/{type}/{id}', [PostManagementController::class, 'destroy'])->name('destroy');
    });
    
    // Kept for backward compatibility if needed, but redirects to posts
    Route::get('/music', function() { return redirect()->route('admin.posts.index'); })->name('music.index');
});