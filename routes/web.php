<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\MusicController;


Route::get('/welcome', function () {
    return view('welcome'); // this points to resources/views/welcome.blade.php
})->name('welcome');

Route::get('/welcome_clean', function () {
    return view('welcome_clean'); // points to resources/views/welcome_clean.blade.php
})->name('welcome_clean');

// Registration routes
Route::get('/register', function () {
    if (Auth::check()) {
        return redirect('/');
    }
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

// Simple auth routes (lightweight, uses the App\Models\User model)
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/welcome_clean');
    }
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



Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('welcome'); // redirect to welcome.blade.php
})->name('logout');


// Note: dashboard removed; bookmarks app lives at /welcome_clean

// Bookmarks API (persisted per user)

use App\Http\Controllers\BookmarkController;

Route::middleware('auth')->group(function() {
    Route::get('/bookmarks', [BookmarkController::class, 'index']);
    Route::post('/bookmarks', [BookmarkController::class, 'store']);
    Route::delete('/bookmarks/{id}', [BookmarkController::class, 'destroy']);
});


Route::middleware('auth')->group(function () {
    Route::get('/music', [MusicController::class, 'index'])->name('music.index');
    Route::post('/music', [MusicController::class, 'store'])->name('music.store');
});
