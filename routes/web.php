<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\MusicController;


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
        'password' => ['required','confirmed','min:6'],
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
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
