<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Audiobook — Bookmarks</title>
<link href="https://fonts.cdnfonts.com/css/formula1-display" rel="stylesheet">
<style>
/* --- Original CSS (Preserved) --- */
*, *::before, *::after { box-sizing: border-box; }
:root { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; color: #fff; --move-x: 0px; --move-y: 0px; }

/* UPDATED: Body Layout for Sidebar */
body { 
    margin: 0; 
    min-height: 100vh; 
    display: flex; 
    flex-direction: row; /* Side-by-side layout */
    overflow-x: hidden; 
    position: relative; 
}

/* Backgrounds (Untouched) */
.bg-layer { position: fixed; inset: 0; width: 100%; height: 100%; pointer-events: none; }
.bg-blue { background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%); z-index: -10; }
.bg-gray { background: linear-gradient(135deg, #2b2b2b 0%, #3a3a3a 60%, #4f4f4f 100%); z-index: -9; opacity: 0; animation: fadeCycle 15s infinite ease-in-out; }
@keyframes fadeCycle { 0%, 40% { opacity: 0; } 50%, 90% { opacity: 1; } 100% { opacity: 0; } }
body::before { content: ""; position: fixed; inset: -5%; width: 110%; height: 110%; z-index: -4; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 800'%3E%3Cpath fill='%23ffffff' fill-opacity='0.05' d='M0,256L48,261.3C96,267,192,277,288,293.3C384,309,480,331,576,314.7C672,299,768,245,864,245.3C960,245,1056,299,1152,298.7C1248,299,1344,245,1392,218.7L1440,192L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3C/svg%3E"); background-size: cover; opacity: 0.4; pointer-events: none; transform: translate(var(--move-x), var(--move-y)); transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); }

.waves-container { position: fixed; left: -10%; width: 120%; height: 50vh; z-index: -1; pointer-events: none; }
.waves-bottom { bottom: -100px; }
.waves-top { top: -100px; transform: rotate(180deg); }
.waves { position: relative; width: 100%; height: 100%; transform: translate3d(var(--move-x), var(--move-y), 0); transition: transform 0.1s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
.parallax > use { animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite; }
.parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; fill: rgba(255, 255, 255, 0.05); }
.parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; fill: rgba(255, 255, 255, 0.1); }
.parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; fill: rgba(255, 255, 255, 0.15); }
.parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; fill: rgba(255, 255, 255, 0.2); }
@keyframes move-forever { 0% { transform: translate3d(-90px, 0, 0); } 100% { transform: translate3d(85px, 0, 0); } }

/* --- NEW Sidebar Styles --- */
.sidebar {
    width: 240px;
    height: 100vh;
    position: sticky;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    padding: 30px 20px;
    background: rgba(0,0,0,0.1); /* Minimalist / Transparent */
    backdrop-filter: blur(5px);
    border-right: 1px solid rgba(255,255,255,0.05);
    z-index: 100;
    flex-shrink: 0;
}

.sidebar h1 { font-family: 'Formula1 Display', sans-serif; font-size: 24px; margin: 0 0 40px 0; }
.sidebar h1 a { color: #fff; text-decoration: none; }

.nav-links { display: flex; flex-direction: column; gap: 15px; }
.nav-link { 
    color: #ccc; text-decoration: none; font-weight: 600; font-size: 16px; 
    padding: 8px 0; transition: 0.2s; display: block;
}
.nav-link:hover { color: #fff; transform: translateX(5px); }
.nav-link.active { color: #00f0ff; }

.sidebar-footer { margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); }
.user-info { font-size: 13px; line-height: 1.4; margin-bottom: 12px; color: #eee; }
.logout-btn { 
    width: 100%; padding: 10px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2); 
    background: rgba(255,255,255,0.05); color: #ff6666; cursor: pointer; transition: 0.2s; font-size: 13px; font-weight: 600; 
}
.logout-btn:hover { background: rgba(255,50,50,0.1); border-color: rgba(255,50,50,0.4); color: #ff8888; }
.admin-btn { 
    display: block; text-align: center; padding: 8px; border-radius: 8px; background: #ffaa00; 
    color: #000; text-decoration: none; font-weight: 700; font-size: 12px; margin-bottom: 10px; 
}
.admin-btn:hover { background: #ffc144; }

/* --- Main Content (Preserved Layout) --- */
/* Wrapper to handle the right side area */
.content-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    width: 100%;
}

/* Original Main Styles (Adapted for flex container) */
main { 
    width: 100%; 
    max-width: 1200px; 
    margin: 30px auto; 
    display: flex; 
    gap: 24px; 
    padding: 0 18px; 
    z-index: 1; 
}

/* Original Column & Card Styles */
.column-left { flex: 1; }
.column-right { flex: 1; display: flex; flex-direction: column; gap: 12px; }
.card { width: 100%; background: rgba(0,0,0,0.55); backdrop-filter: blur(8px); border-radius: 16px; padding: 24px 18px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
.card h2 { font-family: 'Formula1 Display', sans-serif; font-size: 24px; text-align: center; }
.card p { font-size: 13px; opacity: 0.85; text-align: center; }

input[type="text"], input[type="url"], input[type="file"], input[type="date"], select { width: 100%; padding: 12px 14px; border: 1px solid rgba(255,255,255,0.4); border-radius: 8px; background: rgba(255,255,255,0.1); color: #fff; margin-bottom: 8px; font-size: 15px; }
option { background: #333; }
.btn { padding: 12px 20px; border-radius: 50px; border: none; cursor: pointer; font-size: 15px; font-weight: 600; text-decoration: none; display: inline-block; text-align: center; }
.btn-primary { background: #fff; color: #0057ff; }
.btn-primary:hover { background: #eaeaea; }
.btn-ghost { background: rgba(255,255,255,0.25); color: #fff; border:1px solid rgba(255,255,255,0.3); }
.btn-ghost:hover { background: rgba(255,255,255,0.35); }

.item { display: flex; gap: 12px; padding: 12px; border-radius: 8px; background: rgba(255,255,255,0.05); }
.item img { width: 72px; height: 72px; border-radius: 8px; object-fit: cover; }
.item a { font-weight: 700; font-size: 15px; color: #fff; text-decoration: none; }
.tags { font-size: 13px; opacity: 0.75; }
.alert-error { background: rgba(255, 0, 0, 0.15); border: 1px solid rgba(255, 0, 0, 0.3); color: #ff9999; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 13px; text-align: left; }
.alert-error ul { margin: 0; padding-left: 20px; }
</style>
</head>

<body>

<div class="bg-layer bg-blue"></div>
<div class="bg-layer bg-gray"></div>

<aside class="sidebar">
    <h1><a href="{{ route('welcome') }}">Audiobook</a></h1>
    
    <nav class="nav-links">
        <a href="{{ route('welcome') }}" class="nav-link">Home</a>
        <a href="{{ route('feed') }}" class="nav-link">Feed</a>
        <a href="{{ route('welcome_clean') }}" class="nav-link active">Bookmarks</a>
    </nav>

    <div class="sidebar-footer">
        @auth
            <div class="user-info">
                Signed in as<br>
                <strong>{{ Auth::user()->name }}</strong>
            </div>
            
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="admin-btn">Admin Dashboard</a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn-ghost" style="width:100%; display:block; text-align:center; padding:10px; border-radius:8px;">Sign In</a>
        @endauth
    </div>
</aside>

<div class="content-area">
    
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

    <main>
        <div class="column-left">
            <div class="card">
                @auth
                    <h2>Add Music Bookmark</h2>
                    <p>Save songs, album pages, artist pages, and streaming links.</p>

                    @if ($errors->any())
                        <div class="alert-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ url('/bookmarks') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="title" placeholder="Song title (optional)" value="{{ old('title') }}">
                        <input type="text" name="artist" placeholder="Artist (required)" required value="{{ old('artist') }}">
                        <input type="text" name="genre" placeholder="Genre (optional)" value="{{ old('genre') }}">
                        
                        <input type="url" name="url" placeholder="http://googleusercontent.com/spotify.com/..." required value="{{ old('url') }}">
                        
                        <label style="font-size:13px; opacity:0.8;">Release date (optional)</label>
                        <input type="date" name="release_date" style="margin-bottom:8px;" value="{{ old('release_date') }}">
                        
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
                @else
                    <h2>Join the Community</h2>
                    <p>Sign in to upload your own bookmarks and save music.</p>
                    <div style="display:flex; gap:10px; justify-content:center; margin-top:20px;">
                        <a href="{{ route('login') }}" class="btn btn-primary">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-ghost">Register</a>
                    </div>
                @endauth
            </div>
        </div>

        <div class="column-right">
            <div class="card" style="margin-bottom:12px;">
                <form method="GET" action="{{ route('welcome_clean') }}" style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                    <div style="flex:1; min-width:160px;">
                        <input type="text" name="q" placeholder="Search artist or title" value="{{ request('q') }}" style="width:100%; margin:0; padding:10px;">
                    </div>
                    
                    <div style="min-width:140px;">
                        <select name="genre" style="margin:0; padding:10px;">
                            <option value="">All genres</option>
                            @foreach($genres as $g)
                                <option value="{{ $g }}" {{ request('genre') == $g ? 'selected' : '' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="min-width:140px;">
                        <select name="sort_by" style="margin:0; padding:10px;">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Newest</option>
                            <option value="artist" {{ request('sort_by') == 'artist' ? 'selected' : '' }}>Artist (A–Z)</option>
                            <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                            <option value="rating_avg" {{ request('sort_by') == 'rating_avg' ? 'selected' : '' }}>Rating</option>
                        </select>
                    </div>

                    <div style="min-width:110px;">
                        <select name="order" style="margin:0; padding:10px;">
                            <option value="desc" {{ request('order') == 'desc' || !request('order') ? 'selected' : '' }}>Desc</option>
                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Asc</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" style="padding:10px 20px;">Apply</button>
                </form>
            </div>

            @forelse ($bookmarks as $bookmark)
                <div class="item">
                    @if($bookmark->image)
                        <img src="{{ asset('storage/' . $bookmark->image) }}">
                    @else
                        <img src="https://via.placeholder.com/72?text=Music">
                    @endif

                    <div style="flex:1;">
                        <a href="{{ $bookmark->url }}" target="_blank">
                            {{ $bookmark->title ?? 'Untitled Song' }}
                        </a>
                        <div class="tags">
                            {{ $bookmark->artist }} 
                            @if($bookmark->genre) · <em>{{ $bookmark->genre }}</em>@endif
                        </div>
                        
                        <div style="font-size:12px; color:#aaa; margin-top:6px;">
                            Posted by <strong>{{ $bookmark->user->name ?? 'Unknown' }}</strong> · 
                            ⭐ {{ number_format($bookmark->rating_avg,1) }} · {{ $bookmark->views }} views
                        </div>

                        <div style="font-size:12px; color:#bdbdbd; margin-top:6px;">
                             Uploaded: {{ $bookmark->uploaded_at ? $bookmark->uploaded_at->format('M j, Y') : 'Unknown' }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="card">No bookmarks found.</div>
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