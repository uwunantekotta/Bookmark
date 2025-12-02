<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Audiobook — Bookmarks</title>

<link href="https://fonts.cdnfonts.com/css/formula1-display" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }

:root {
    font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
    color: #fff;
}

body {
    margin: 0;
    min-height: 100vh;
    background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow-x: hidden;
}

header {
    width: 100%;
    max-width: 1200px;
    margin: 18px auto 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 18px;
    z-index: 1;
}

header h1 {
    font-family: 'Formula1 Display', sans-serif;
    font-size: 28px;
    margin: 0;
}

nav a {
    margin-right: 18px;
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    transition: 0.2s;
}

nav a:hover {
    color: #00f0ff;
}

.logout-btn {
    padding: 8px 12px;
    margin-left: 8px;
    border-radius: 50px;
    border: 1px solid rgba(255,255,255,0.6);
    background: rgba(255,255,255,0.1);
    color: #fff;
    cursor: pointer;
    transition: 0.2s;
}

.logout-btn:hover {
    background: rgba(255,255,255,0.2);
}

main {
    flex: 1;
    width: 100%;
    max-width: 1200px;
    margin: 30px auto;
    display: flex;
    gap: 24px;
    padding: 0 18px;
}

.column-left { flex: 1; }

.card {
    width: 100%;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    padding: 24px 18px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
}

.card h2 {
    font-family: 'Formula1 Display', sans-serif;
    font-size: 24px;
    text-align: center;
}

.card p {
    font-size: 13px;
    opacity: 0.85;
    text-align: center;
}

input[type="text"], input[type="url"], input[type="file"] {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid rgba(255,255,255,0.4);
    border-radius: 8px;
    background: rgba(255,255,255,0.1);
    color: #fff;
    margin-bottom: 8px;
    font-size: 15px;
}

.btn {
    padding: 12px 20px;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
}

.btn-primary { background: #fff; color: #0057ff; }
.btn-primary:hover { background: #eaeaea; }

.btn-ghost { background: rgba(255,255,255,0.25); color: #fff; border:1px solid rgba(255,255,255,0.3); }
.btn-ghost:hover { background: rgba(255,255,255,0.35); }

.column-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.item {
    display: flex;
    gap: 12px;
    padding: 12px;
    border-radius: 8px;
    background: rgba(255,255,255,0.05);
}

.item img {
    width: 72px;
    height: 72px;
    border-radius: 8px;
    object-fit: cover;
}

.item a {
    font-weight: 700;
    font-size: 15px;
    color: #fff;
    text-decoration: none;
}

.tags {
    font-size: 13px;
    opacity: 0.75;
}
</style>
</head>

<body>

<header>
    <!-- Logo -->
    <h1>
        <a href="{{ route('welcome') }}" style="color:white;text-decoration:none;">Audiobook</a>
    </h1>

    <!-- Navigation -->
    <nav>
        <a href="{{ route('welcome') }}">Home</a>
        <a href="{{ route('bookmarks') }}">Add Bookmark</a>
        <a href="{{ route('bookmarks') }}">Bookmarks</a>
    </nav>

    <!-- Auth -->
    <div style="display:flex;align-items:center;">
        @auth
            <div style="text-align:right;font-size:13px;">
                Signed in as<br><strong>{{ Auth::user()->name }}</strong>
            </div>
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @endauth
    </div>
</header>

<main>
    <!-- LEFT COLUMN — ADD BOOKMARK -->
    <div class="column-left">
        <div class="card">
            <h2>Add Music Bookmark</h2>
            <p>Save songs, album pages, artist pages, and streaming links.</p>

            <form action="{{ url('/bookmarks') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="title" placeholder="Song title (optional)">
                <input type="text" name="artist" placeholder="Artist (required)" required>
                <input type="url" name="url" placeholder="https://open.spotify.com/track/..." required>
                <label style="font-size:13px; opacity:0.8;">Attach photo (optional)</label>
                <input type="file" name="image" accept="image/*">

                <div style="display:flex; gap:8px; justify-content:center; margin-top:4px;">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-ghost">Clear</button>
                </div>
            </form>

            @if(session('success'))
                <p style="margin-top:10px;text-align:center;color:#00f0ff;font-size:14px;">
                    {{ session('success') }}
                </p>
            @endif
        </div>
    </div>

    <!-- RIGHT COLUMN — SHOW SAVED BOOKMARKS -->
    <div class="column-right">
        @foreach ($bookmarks as $bookmark)
            <div class="item">
                <!-- Image -->
                @if($bookmark->image)
                    <img src="{{ asset('storage/' . $bookmark->image) }}">
                @else
                    <img src="https://via.placeholder.com/72">
                @endif

                <div style="flex:1;">
                    <a href="{{ $bookmark->url }}" target="_blank">
                        {{ $bookmark->title ?? 'Untitled Song' }}
                    </a>
                    <div class="tags">{{ $bookmark->artist }}</div>
                </div>
            </div>
        @endforeach
    </div>
</main>

</body>
</html>
