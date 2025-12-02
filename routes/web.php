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
use App\Http\Controllers\MusicApprovalController;


// ------------------------
// Public Routes
// ------------------------

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// ------------------------
// Welcome Clean (show bookmarks on right side)
// ------------------------

Route::get('/welcome_clean', [BookmarkController::class, 'showWelcome'])
    ->middleware('auth')
    ->name('welcome_clean');


// ------------------------
// Registration
// ------------------------

Route::get('/register', function () {
    if (Auth::check()) return redirect('/');
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {

    $data = $request->validate([
        'name' => ['required','string','max:255'],
        'email' => ['required','email','max:255','unique:users,email'],
        // Password must match client-side requirements: 8-64 chars, 1 uppercase, 1 number, 1 symbol
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


// ------------------------
// Login
// ------------------------

Route::get('/login', function () {
    if (Auth::check()) return redirect('/welcome_clean');
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email' => ['required','email'],
        'password' => ['required'],
    ]);

    $remember = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        return redirect()->intended('/welcome_clean');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
});


// ------------------------
// Logout
// ------------------------

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('welcome');
})->name('logout');


// ------------------------
// Bookmarks (CRUD)
// ------------------------

Route::middleware('auth')->group(function () {
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks');
    Route::post('/bookmarks', [BookmarkController::class, 'store']);
    Route::delete('/bookmarks/{id}', [BookmarkController::class, 'destroy']);
});


// ------------------------
// Music Upload
// ------------------------

Route::middleware('auth')->group(function () {
    Route::get('/music', [MusicController::class, 'index'])->name('music.index');
    Route::post('/music', [MusicController::class, 'store'])->name('music.store');
});


// ------------------------
// Admin Routes
// ------------------------

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/banned', [UserManagementController::class, 'banned'])->name('banned');
        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{user}/role', [UserManagementController::class, 'updateRole'])->name('updateRole');
        Route::post('/{user}/ban', [UserManagementController::class, 'ban'])->name('ban');
        Route::post('/{user}/unban', [UserManagementController::class, 'unban'])->name('unban');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    // Music Approval
    Route::prefix('music')->name('music.')->group(function () {
        Route::get('/', [MusicApprovalController::class, 'index'])->name('index');
        Route::post('/{music}/approve', [MusicApprovalController::class, 'approve'])->name('approve');
        Route::post('/{music}/reject', [MusicApprovalController::class, 'reject'])->name('reject');
        Route::get('/rejected', [MusicApprovalController::class, 'rejectedList'])->name('rejected');
    });
});
