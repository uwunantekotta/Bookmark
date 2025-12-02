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
    /* Initialize CSS variables for mouse interaction */
    --move-x: 0px;
    --move-y: 0px;
}

body {
    margin: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow-x: hidden;
    position: relative;
}

/* Background Color Layers */
.bg-layer {
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.bg-blue {
    background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%);
    z-index: -10;
}

.bg-gray {
    background: linear-gradient(135deg, #2b2b2b 0%, #3a3a3a 60%, #4f4f4f 100%);
    z-index: -9;
    opacity: 0;
    animation: fadeCycle 15s infinite ease-in-out;
}

@keyframes fadeCycle {
    0%, 40% { opacity: 0; }
    50%, 90% { opacity: 1; }
    100% { opacity: 0; }
}

body::before {
    content: "";
    position: fixed;
    inset: -5%;
    width: 110%;
    height: 110%;
    z-index: -4;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 800'%3E%3Cpath fill='%23ffffff' fill-opacity='0.05' d='M0,256L48,261.3C96,267,192,277,288,293.3C384,309,480,331,576,314.7C672,299,768,245,864,245.3C960,245,1056,299,1152,298.7C1248,299,1344,245,1392,218.7L1440,192L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,416L48,421.3C96,427,192,437,288,421.3C384,405,480,363,576,362.7C672,363,768,405,864,432C960,459,1056,469,1152,448C1248,427,1344,373,1392,346.7L1440,320L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.15' d='M0,576L48,586.7C96,597,192,619,288,602.7C384,587,480,533,576,512C672,491,768,501,864,528C960,555,1056,597,1152,597.3C1248,597,1344,555,1392,533.3L1440,512L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3C/svg%3E");
    background-size: cover;
    background-position: center bottom;
    opacity: 0.4;
    pointer-events: none;
    
    /* Interactive transform */
    transform: translate(var(--move-x), var(--move-y));
    transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

/* WAVE ANIMATIONS */
.waves-container {
    position: fixed;
    left: -10%;
    width: 120%;
    height: 50vh;
    z-index: -1;
    pointer-events: none;
}

.waves-bottom { bottom: -100px; }
.waves-top { top: -100px; transform: rotate(180deg); }

.waves {
    position: relative;
    width: 100%;
    height: 100%;
    margin-bottom: -7px;
    min-height: 100px;
    transform: translate3d(var(--move-x), var(--move-y), 0);
    transition: transform 0.1s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.parallax > use {
    animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
}
.parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; fill: rgba(255, 255, 255, 0.05); }
.parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; fill: rgba(255, 255, 255, 0.1); }
.parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; fill: rgba(255, 255, 255, 0.15); }
.parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; fill: rgba(255, 255, 255, 0.2); }

@keyframes move-forever {
    0% { transform: translate3d(-90px, 0, 0); }
    100% { transform: translate3d(85px, 0, 0); }
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

/* Styles specifically for the Auth/Admin section */
.auth-controls {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-info {
    text-align: right;
    font-size: 13px;
    line-height: 1.2;
}

.logout-btn {
    padding: 8px 12px;
    border-radius: 50px;
    border: 1px solid rgba(255,255,255,0.6);
    background: rgba(255,255,255,0.1);
    color: #fff;
    cursor: pointer;
    transition: 0.2s;
    font-size: 13px;
    font-weight: 600;
}

.logout-btn:hover {
    background: rgba(255,255,255,0.2);
}

.admin-btn {
    padding: 8px 16px;
    border-radius: 50px;
    border: none;
    background: #ffaa00; /* Orange color from your screenshot */
    color: #000;
    text-decoration: none;
    font-weight: 700;
    font-size: 13px;
    transition: 0.2s;
}

.admin-btn:hover {
    background: #ffc144;
}

main {
    flex: 1;
    width: 100%;
    max-width: 1200px;
    margin: 30px auto;
    display: flex;
    gap: 24px;
    padding: 0 18px;
    z-index: 1;
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

<div class="bg-layer bg-blue"></div>
<div class="bg-layer bg-gray"></div>

<div class="waves-container waves-top">
    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
    <defs><path id="gentle-wave-top" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs>
    <g class="parallax">
    <use xlink:href="#gentle-wave-top" x="48" y="0" />
    <use xlink:href="#gentle-wave-top" x="48" y="3" />
    <use xlink:href="#gentle-wave-top" x="48" y="5" />
    <use xlink:href="#gentle-wave-top" x="48" y="7" />
    </g>
    </svg>
</div>

<header>
    <h1>
        <a href="{{ route('welcome') }}" style="color:white;text-decoration:none;">Audiobook</a>
    </h1>

    <nav>
        <a href="{{ route('welcome') }}">Home</a>
        <a href="{{ route('bookmarks') }}">Add Bookmark</a>
        <a href="{{ route('bookmarks') }}">Bookmarks</a>
    </nav>

    <div class="auth-controls">
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="admin-btn">Admin Dashboard</a>
            @endif

            <div class="user-info">
                Signed in as<br><strong>{{ Auth::user()->name }}</strong>
            </div>
            
            <form method="POST" action="{{ url('/logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @endauth
    </div>
</header>

<main>
    <div class="column-left">
        <div class="card">
            <h2>Add Music Bookmark</h2>
            <p>Save songs, album pages, artist pages, and streaming links.</p>

            <form action="{{ url('/bookmarks') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="title" placeholder="Song title (optional)">
                <input type="text" name="artist" placeholder="Artist (required)" required>
                <input type="url" name="url" placeholder="https://open.spotify.com/track/..." required>
                <label style="font-size:13px; opacity:0.8;">Release date (optional)</label>
                <input type="date" name="release_date" style="width:100%; padding:12px 14px; border: 1px solid rgba(255,255,255,0.4); border-radius:8px; background: rgba(255,255,255,0.06); color:#fff; margin-bottom:8px;">
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

    <div class="column-right">

        <div class="card" style="margin-bottom:12px;">
            <form method="GET" action="{{ route('welcome_clean') }}" style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                <div style="flex:1; min-width:160px;">
                    <input type="text" name="q" placeholder="Search artist or title" value="{{ request('q') }}" style="width:100%; padding:10px;">
                </div>

                <div style="min-width:160px;">
                    <select name="genre" style="padding:10px; min-width:160px;">
                        <option value="">All genres</option>
                        @if(isset($genres))
                            @foreach($genres as $g)
                                <option value="{{ $g }}" {{ request('genre') == $g ? 'selected' : '' }}>{{ $g }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div style="min-width:160px;">
                    <select name="sort_by" style="padding:10px; min-width:160px;">
                        <option value="artist" {{ request('sort_by')=='artist' ? 'selected' : '' }}>Artist (A–Z)</option>
                        <option value="title" {{ request('sort_by')=='title' ? 'selected' : '' }}>Title</option>
                        <option value="genre" {{ request('sort_by')=='genre' ? 'selected' : '' }}>Genre</option>
                        <option value="rating_avg" {{ request('sort_by')=='rating_avg' ? 'selected' : '' }}>Rating</option>
                        <option value="reviews_count" {{ request('sort_by')=='reviews_count' ? 'selected' : '' }}>Reviews</option>
                        <option value="views" {{ request('sort_by')=='views' ? 'selected' : '' }}>Views</option>
                        <option value="created_at" {{ request('sort_by')=='created_at' ? 'selected' : '' }}>Newest</option>
                    </select>
                </div>

                <div style="min-width:120px;">
                    <select name="order" style="padding:10px;">
                        <option value="asc" {{ request('order')=='asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('order')=='desc' || !request('order') ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Apply</button>
                </div>
            </form>
        </div>

        @forelse ($bookmarks as $bookmark)
            <div class="item">
                @if($bookmark->image)
                    <img src="{{ asset('storage/' . $bookmark->image) }}">
                @else
                    <img src="https://via.placeholder.com/72">
                @endif

                <div style="flex:1;">
                    <a href="{{ $bookmark->url }}" target="_blank">
                        {{ $bookmark->title ?? 'Untitled Song' }}
                    </a>
                    <div class="tags">{{ $bookmark->artist }} @if($bookmark->genre) · <em>{{ $bookmark->genre }}</em>@endif</div>
                    <div style="font-size:12px; color:#aaa; margin-top:6px;">
                        ⭐ {{ number_format($bookmark->rating_avg,1) }} · {{ $bookmark->reviews_count }} reviews · {{ $bookmark->views }} views
                    </div>

                    <div style="font-size:12px; color:#bdbdbd; margin-top:6px;">
                        @if($bookmark->release_date)
                            Release: {{ $bookmark->release_date->format('M j, Y') }}
                        @endif
                        @if($bookmark->uploaded_at)
                            @if($bookmark->release_date) · @endif Uploaded: {{ $bookmark->uploaded_at->format('M j, Y') }}
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="card">No results found.</div>
        @endforelse

        <div style="margin-top:12px;">{{ $bookmarks->links() }}</div>
    </div>
</main>

<div class="waves-container waves-bottom">
    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
    <defs><path id="gentle-wave-bottom" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs>
    <g class="parallax">
    <use xlink:href="#gentle-wave-bottom" x="48" y="0" />
    <use xlink:href="#gentle-wave-bottom" x="48" y="3" />
    <use xlink:href="#gentle-wave-bottom" x="48" y="5" />
    <use xlink:href="#gentle-wave-bottom" x="48" y="7" />
    </g>
    </svg>
</div>

<script>
    document.addEventListener('mousemove', (e) => {
        const { clientX, clientY } = e;
        const x = (window.innerWidth / 2 - clientX) / 50;
        const y = (window.innerHeight / 2 - clientY) / 50;
        document.documentElement.style.setProperty('--move-x', `${x}px`);
        document.documentElement.style.setProperty('--move-y', `${y}px`);
    });
</script>

</body>
</html>