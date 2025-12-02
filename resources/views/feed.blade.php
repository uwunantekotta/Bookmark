<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feed — Audiobook</title>
    <link href="https://fonts.cdnfonts.com/css/formula1-display" rel="stylesheet">
    <style>
        /* [Previous CSS Standard Resets] */
        *, *::before, *::after { box-sizing: border-box; }
        :root { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; color: #fff; --move-x: 0px; --move-y: 0px; }
        
        /* UPDATED: Flex Layout for Sidebar */
        body { margin: 0; min-height: 100vh; display: flex; flex-direction: row; overflow-x: hidden; position: relative; }

        /* Background Effects (Preserved) */
        .bg-layer { position: fixed; inset: 0; width: 100%; height: 100%; pointer-events: none; }
        .bg-blue { background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%); z-index: -10; }
        .bg-gray { background: linear-gradient(135deg, #2b2b2b 0%, #3a3a3a 60%, #4f4f4f 100%); z-index: -9; opacity: 0; animation: fadeCycle 15s infinite ease-in-out; }
        @keyframes fadeCycle { 0%, 40% { opacity: 0; } 50%, 90% { opacity: 1; } 100% { opacity: 0; } }
        body::before { content: ""; position: fixed; inset: -5%; width: 110%; height: 110%; z-index: -4; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 800'%3E%3Cpath fill='%23ffffff' fill-opacity='0.05' d='M0,256L48,261.3C96,267,192,277,288,293.3C384,309,480,331,576,314.7C672,299,768,245,864,245.3C960,245,1056,299,1152,298.7C1248,299,1344,245,1392,218.7L1440,192L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,416L48,421.3C96,427,192,437,288,421.3C384,405,480,363,576,362.7C672,363,768,405,864,432C960,459,1056,469,1152,448C1248,427,1344,373,1392,346.7L1440,320L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.15' d='M0,576L48,586.7C96,597,192,619,288,602.7C384,587,480,533,576,512C672,491,768,501,864,528C960,555,1056,597,1152,597.3C1248,597,1344,555,1392,533.3L1440,512L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3C/svg%3E"); background-size: cover; opacity: 0.4; pointer-events: none; transform: translate(var(--move-x), var(--move-y)); transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .waves-container { position: fixed; left: -10%; width: 120%; height: 50vh; z-index: -1; pointer-events: none; }
        .waves-bottom { bottom: -100px; }
        .waves-top { top: -100px; transform: rotate(180deg); }
        .waves { position: relative; width: 100%; height: 100%; margin-bottom: -7px; min-height: 100px; transform: translate3d(var(--move-x), var(--move-y), 0); transition: transform 0.1s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .parallax > use { animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite; }
        .parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; fill: rgba(255, 255, 255, 0.05); }
        .parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; fill: rgba(255, 255, 255, 0.1); }
        .parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; fill: rgba(255, 255, 255, 0.15); }
        .parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; fill: rgba(255, 255, 255, 0.2); }
        @keyframes move-forever { 0% { transform: translate3d(-90px, 0, 0); } 100% { transform: translate3d(85px, 0, 0); } }

        /* --- NEW: Sidebar Styles --- */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: sticky;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 30px 20px;
            background: rgba(0,0,0,0.1);
            backdrop-filter: blur(5px);
            border-right: 1px solid rgba(255,255,255,0.05);
            z-index: 100;
            flex-shrink: 0;
        }

        .sidebar h1 { font-family: 'Formula1 Display', sans-serif; font-size: 24px; margin: 0 0 40px 0; }
        .sidebar h1 a { color: #fff; text-decoration: none; }

        .nav-links { display: flex; flex-direction: column; gap: 15px; }
        .nav-link { color: #ccc; text-decoration: none; font-weight: 600; font-size: 16px; padding: 8px 0; transition: 0.2s; display: block; }
        .nav-link:hover { color: #fff; transform: translateX(5px); }
        .nav-link.active { color: #00f0ff; }

        .sidebar-footer { margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-info { font-size: 13px; line-height: 1.4; margin-bottom: 12px; color: #eee; }
        .logout-btn { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.05); color: #ff6666; cursor: pointer; transition: 0.2s; font-size: 13px; font-weight: 600; }
        .logout-btn:hover { background: rgba(255,50,50,0.1); border-color: rgba(255,50,50,0.4); color: #ff8888; }
        .admin-btn { display: block; text-align: center; padding: 8px; border-radius: 8px; background: #ffaa00; color: #000; text-decoration: none; font-weight: 700; font-size: 12px; margin-bottom: 10px; }
        .admin-btn:hover { background: #ffc144; }

        /* --- Content Area Wrapper --- */
        .content-area {
            flex: 1;
            padding: 40px;
            max-width: 900px; /* Kept existing container max-width */
            margin: 0 auto; /* Center content in the remaining space */
            position: relative;
        }

        /* --- Search Bar --- */
        .search-bar { background: rgba(40,40,40,0.6); backdrop-filter: blur(10px); padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.05); display: flex; gap: 10px; }
        .search-input { flex: 1; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 10px 15px; border-radius: 8px; outline: none; transition: 0.2s; }
        .search-input:focus { border-color: #00f0ff; background: rgba(0,0,0,0.5); }
        .search-btn { background: #00f0ff; color: #000; border: none; padding: 0 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s; }
        .search-btn:hover { background: #00d4e8; }

        /* --- Post Styles (Preserved) --- */
        .post { background: rgba(40, 40, 40, 0.6); backdrop-filter: blur(10px); border-radius: 12px; margin-bottom: 16px; padding: 20px; border: 1px solid rgba(255,255,255,0.05); display: grid; grid-template-columns: 60px 1fr 120px; gap: 20px; align-items: start; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .avatar { width: 50px; height: 50px; border-radius: 50%; background: #1a1a1a; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px; color: #eee; border: 1px solid rgba(255,255,255,0.1); }
        .post-content { display: flex; flex-direction: column; gap: 6px; min-height: 100px; position: relative; }
        .title { font-weight: 800; font-size: 18px; color: #fff; line-height: 1.2; }
        .author-line { font-size: 14px; color: #ccc; display: flex; align-items: center; gap: 8px; }
        .role-badge { padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .role-badge.admin { background: #ffcccc; color: #cc0000; }
        .role-badge.contributor { background: #ffeebb; color: #b25a00; }
        .role-badge.viewer { background: #ddffea; color: #007a3d; }
        .meta { font-size: 13px; color: #888; font-style: italic; }
        .action-area { margin-top: auto; padding-top: 15px; }
        .post-right { display: flex; flex-direction: column; align-items: flex-end; justify-content: space-between; height: 100%; text-align: right; }
        .media-placeholder { width: 100px; height: 80px; border-radius: 8px; overflow: hidden; background: #000; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.1); }
        .media-placeholder img { width: 100%; height: 100%; object-fit: cover; }
        .rating-container { margin-top: auto; padding-top: 10px; }
        .rating-text { font-size: 11px; color: #777; margin-bottom: 2px; }
        .btn-open { background: rgba(255,255,255,0.15); color: #fff; text-decoration: none; padding: 8px 20px; border-radius: 6px; font-size: 13px; font-weight: 600; transition: background 0.2s; display: inline-block; }
        .btn-open:hover { background: rgba(255,255,255,0.25); }
        .btn-action { font-size: 11px; padding: 6px 12px; border-radius: 4px; border: none; cursor: pointer; font-weight: 600; margin-left: 8px; }
        .btn-approve { background: #2ecc71; color: #042; }
        .btn-reject { background: #e74c3c; color: #fff; }
        .star-group { display: inline-flex; flex-direction: row; }
        .star-btn { background: none; border: none; cursor: pointer; font-size: 16px; color: #555; padding: 0 1px; transition: color 0.2s; }
        .star-btn:hover, .star-btn:hover ~ .star-btn { color: #555; } 
        .star-group:hover .star-btn { color: #ffaa00; } 
        .star-btn:hover ~ .star-btn { color: #555; } 
        .star-btn.active { color: #ffaa00; }
        .static-stars { color: #ffaa00; font-size: 16px; letter-spacing: 1px; }
        .static-stars.inactive { color: #444; }

        @media (max-width: 900px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: relative; border-right: none; border-bottom: 1px solid rgba(255,255,255,0.1); }
            .content-area { padding: 20px; }
            .post { grid-template-columns: 50px 1fr; gap: 15px; }
            .post-right { grid-column: 2; flex-direction: row; align-items: center; justify-content: space-between; margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 10px; width: 100%; }
            .media-placeholder { width: 50px; height: 50px; }
            .rating-container { margin-top: 0; }
        }
    </style>
</head>
<body>
    <div class="bg-layer bg-blue"></div>
    <div class="bg-layer bg-gray"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h1><a href="{{ route('feed') }}">Audiobook</a></h1>
        
        <nav class="nav-links">
            <!-- Viewers should not see Home/Add because they are redirected to feed anyway -->
            @if(auth()->user()->role !== 'viewer')
                <a href="{{ route('welcome') }}" class="nav-link">Home</a>
                <a href="{{ route('welcome_clean') }}" class="nav-link">Add</a>
            @endif
            <a href="{{ route('feed') }}" class="nav-link active">Feed</a>
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
            @endauth
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="content-area">
        <div class="waves-container waves-top"><svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto"><defs><path id="gentle-wave-top" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs><g class="parallax"><use xlink:href="#gentle-wave-top" x="48" y="0" /><use xlink:href="#gentle-wave-top" x="48" y="3" /><use xlink:href="#gentle-wave-top" x="48" y="5" /><use xlink:href="#gentle-wave-top" x="48" y="7" /></g></svg></div>

        <h1 style="font-family:'Formula1 Display', sans-serif; margin-bottom:20px;">Feed</h1>

        <!-- Search Bar -->
        <form action="{{ route('feed') }}" method="GET" class="search-bar">
            <input type="text" name="q" class="search-input" placeholder="Search by song title, artist, or genre..." value="{{ request('q') }}">
            <button type="submit" class="search-btn">Search</button>
        </form>

        @forelse($posts as $post)
            <div class="post">
                <div class="avatar">{{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}</div>
                <div class="post-content">
                    <div class="title">{{ $post->title ?? ($post->artist ? $post->artist : 'Untitled') }}</div>
                    <div class="author-line">
                        by {{ $post->user->name ?? 'Unknown' }}
                        @if(isset($post->user->role))
                            <span class="role-badge {{ $post->user->role }}">{{ ucfirst($post->user->role) }}</span>
                        @endif
                    </div>
                    <div class="meta">
                        {{ $post->artist ?? '' }} 
                        @if($post->genre) · {{ $post->genre }} @endif
                        @if($post->uploaded_at) · Uploaded: {{ \Carbon\Carbon::parse($post->uploaded_at)->format('M j, Y') }} @endif
                    </div>
                    <div class="action-area">
                        <a href="{{ $post->url }}" target="_blank" class="btn-open">Open</a>
                        @auth
                            @if(auth()->user()->isAdmin() && $post->type === 'music' && isset($post->status) && $post->status === 'pending')
                                <form method="POST" action="{{ route('admin.posts.approve', ['music' => $post->id]) }}" style="display:inline">@csrf
                                    <button class="btn-action btn-approve" type="submit">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.posts.reject', ['music' => $post->id]) }}" style="display:inline">@csrf
                                    <button class="btn-action btn-reject" type="submit">Reject</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="post-right">
                    <div class="media-placeholder">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="media">
                        @else
                            @if($post->type === 'bookmark')
                                <img src="https://via.placeholder.com/100x80/000000/FFFFFF?text=WEB" alt="web">
                            @else
                                <img src="{{ asset('images/audiobook-logo.png') }}" onerror="this.src='https://via.placeholder.com/100x80/000000/FFFFFF?text=AUDIO'" alt="audio">
                            @endif
                        @endif
                    </div>
                    <div class="rating-container">
                        <div class="rating-text">Avg: {{ number_format($post->rating_avg, 1) }} ({{ $post->reviews_count }})</div>
                        @auth
                            <form action="{{ route('rate.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="{{ $post->type }}">
                                <input type="hidden" name="id" value="{{ $post->id }}">
                                <div class="star-group">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="submit" name="rating" value="{{ $i }}" class="star-btn {{ $i <= $post->my_rating ? 'active' : '' }}">★</button>
                                    @endfor
                                </div>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div style="padding:40px; background:rgba(40,40,40,0.6); border-radius:12px; text-align:center; color:#aaa; border:1px solid rgba(255,255,255,0.05);">
                No posts available in the feed.
            </div>
        @endforelse

        <div style="margin-top:20px; text-align: center;">{{ $posts->links() }}</div>

        <div class="waves-container waves-bottom"><svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto"><defs><path id="gentle-wave-bottom" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs><g class="parallax"><use xlink:href="#gentle-wave-bottom" x="48" y="0" /><use xlink:href="#gentle-wave-bottom" x="48" y="3" /><use xlink:href="#gentle-wave-bottom" x="48" y="5" /><use xlink:href="#gentle-wave-bottom" x="48" y="7" /></g></svg></div>
    </div>

    <script>document.addEventListener('mousemove', (e) => { const x = (window.innerWidth / 2 - e.clientX) / 50; const y = (window.innerHeight / 2 - e.clientY) / 50; document.documentElement.style.setProperty('--move-x', `${x}px`); document.documentElement.style.setProperty('--move-y', `${y}px`); });</script>
</body>
</html>