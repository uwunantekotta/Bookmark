<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feed — Audiobook</title>
    <link href="https://fonts.cdnfonts.com/css/formula1-display" rel="stylesheet">
    <style>
        /* --- GLOBAL & BACKGROUND STYLES --- */
        :root { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; color: #fff; --move-x: 0px; --move-y: 0px; }
        
        body { margin: 0; min-height: 100vh; overflow-x: hidden; position: relative; padding: 20px; box-sizing: border-box; }
        *, *::before, *::after { box-sizing: inherit; }

        /* Background Layers */
        .bg-layer { position: fixed; inset: 0; width: 100%; height: 100%; pointer-events: none; }
        .bg-blue { background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%); z-index: -10; }
        .bg-gray { background: linear-gradient(135deg, #2b2b2b 0%, #3a3a3a 60%, #4f4f4f 100%); z-index: -9; opacity: 0; animation: fadeCycle 15s infinite ease-in-out; }
        @keyframes fadeCycle { 0%, 40% { opacity: 0; } 50%, 90% { opacity: 1; } 100% { opacity: 0; } }

        /* SVG Texture */
        body::before { content: ""; position: fixed; inset: -5%; width: 110%; height: 110%; z-index: -4; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 800'%3E%3Cpath fill='%23ffffff' fill-opacity='0.05' d='M0,256L48,261.3C96,267,192,277,288,293.3C384,309,480,331,576,314.7C672,299,768,245,864,245.3C960,245,1056,299,1152,298.7C1248,299,1344,245,1392,218.7L1440,192L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,416L48,421.3C96,427,192,437,288,421.3C384,405,480,363,576,362.7C672,363,768,405,864,432C960,459,1056,469,1152,448C1248,427,1344,373,1392,346.7L1440,320L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.15' d='M0,576L48,586.7C96,597,192,619,288,602.7C384,587,480,533,576,512C672,491,768,501,864,528C960,555,1056,597,1152,597.3C1248,597,1344,555,1392,533.3L1440,512L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3C/svg%3E"); background-size: cover; opacity: 0.4; pointer-events: none; transform: translate(var(--move-x), var(--move-y)); transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); }

        /* Wave Animation */
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

        /* --- LAYOUT STYLES --- */
        .container { max-width: 900px; margin: 0 auto; z-index: 1; position: relative; padding-bottom: 100px; }
        
        header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px; 
            padding-bottom: 20px;
        }
        
        h1 { 
            font-family: 'Formula1 Display', sans-serif; 
            font-size: 32px; 
            margin: 0; 
            letter-spacing: -1px;
        }

        nav a { 
            color: #ccc; 
            text-decoration: none; 
            margin-left: 20px; 
            font-size: 15px; 
            font-weight: 500;
            transition: color 0.2s;
        }
        nav a:hover, nav a.active { color: #fff; }
        nav a.active { color: #00f0ff; }

        /* POST CARD - GRID LAYOUT */
        .post { 
            background: rgba(40, 40, 40, 0.6); 
            backdrop-filter: blur(10px); 
            border-radius: 12px; 
            margin-bottom: 16px; 
            padding: 20px;
            border: 1px solid rgba(255,255,255,0.05);
            display: grid;
            grid-template-columns: 60px 1fr 120px; /* Avatar | Content | Right Side */
            gap: 20px;
            align-items: start;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        /* Avatar Column */
        .avatar { 
            width: 50px; 
            height: 50px; 
            border-radius: 50%; 
            background: #1a1a1a; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-weight: 700; 
            font-size: 18px;
            color: #eee;
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* Content Column */
        .post-content {
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-height: 100px; /* Ensure height for button spacing */
            position: relative;
        }

        .title { 
            font-weight: 800; 
            font-size: 18px; 
            color: #fff;
            line-height: 1.2;
        }

        .author-line {
            font-size: 14px;
            color: #ccc;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-badge { 
            padding: 2px 8px; 
            border-radius: 4px; 
            font-size: 11px; 
            font-weight: 700; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .role-badge.admin { background: #ffcccc; color: #cc0000; }
        .role-badge.contributor { background: #ffeebb; color: #b25a00; }
        .role-badge.viewer { background: #ddffea; color: #007a3d; }

        .meta { 
            font-size: 13px; 
            color: #888; 
            font-style: italic;
        }

        .action-area {
            margin-top: auto; /* Pushes button to bottom */
            padding-top: 15px;
        }

        /* Right Column (Media + Rating) */
        .post-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
            height: 100%;
            text-align: right;
        }

        .media-placeholder {
            width: 100px; /* Wider placeholder like the image */
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .media-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rating-container {
            margin-top: auto; /* Push to bottom of right column */
            padding-top: 10px;
        }

        .rating-text {
            font-size: 11px;
            color: #777;
            margin-bottom: 2px;
        }

        /* BUTTONS */
        .btn-open {
            background: rgba(255,255,255,0.15);
            color: #fff;
            text-decoration: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.2s;
            display: inline-block;
        }
        .btn-open:hover { background: rgba(255,255,255,0.25); }

        .btn-action {
            font-size: 11px;
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            margin-left: 8px;
        }
        .btn-approve { background: #2ecc71; color: #042; }
        .btn-reject { background: #e74c3c; color: #fff; }

        /* STAR RATING */
        .star-group { display: inline-flex; flex-direction: row; }
        .star-btn { background: none; border: none; cursor: pointer; font-size: 16px; color: #555; padding: 0 1px; transition: color 0.2s; }
        .star-btn:hover, .star-btn:hover ~ .star-btn { color: #555; } 
        .star-group:hover .star-btn { color: #ffaa00; } 
        .star-btn:hover ~ .star-btn { color: #555; } 
        .star-btn.active { color: #ffaa00; }
        
        .static-stars { color: #ffaa00; font-size: 16px; letter-spacing: 1px; }
        .static-stars.inactive { color: #444; }

        /* Responsive for Mobile */
        @media (max-width: 600px) {
            .post { grid-template-columns: 50px 1fr; gap: 15px; }
            .post-right { 
                grid-column: 2; 
                flex-direction: row; 
                align-items: center; 
                justify-content: space-between;
                margin-top: 10px;
                border-top: 1px solid rgba(255,255,255,0.05);
                padding-top: 10px;
                width: 100%;
            }
            .media-placeholder { width: 50px; height: 50px; }
            .rating-container { margin-top: 0; }
        }
    </style>
</head>
<body>

    <!-- Background Layers -->
    <div class="bg-layer bg-blue"></div>
    <div class="bg-layer bg-gray"></div>

    <!-- Top Wave -->
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

    <div class="container">
        <header>
            <h1>Feed</h1>
            <nav>
                <a href="{{ route('welcome_clean') }}">Home</a>
                <a href="{{ route('bookmarks') }}">Add</a>
                <a href="{{ route('feed') }}" class="active">Feed</a>
            </nav>
        </header>

        @forelse($posts as $post)
            <div class="post">
                <!-- 1. Avatar (Left) -->
                <div class="avatar">
                    {{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                </div>

                <!-- 2. Content (Middle) -->
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
                                <form method="POST" action="{{ route('admin.music.approve', $post->id) }}" style="display:inline">@csrf
                                    <button class="btn-action btn-approve" type="submit">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.music.reject', $post->id) }}" style="display:inline">@csrf
                                    <button class="btn-action btn-reject" type="submit">Reject</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- 3. Right Side (Media & Ratings) -->
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
                        <div class="rating-text">
                            Avg: {{ number_format($post->rating_avg, 1) }} ({{ $post->reviews_count }} reviews)
                        </div>
                        @auth
                            <form action="{{ route('rate.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="{{ $post->type }}">
                                <input type="hidden" name="id" value="{{ $post->id }}">
                                <div class="star-group">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="submit" name="rating" value="{{ $i }}" 
                                            class="star-btn {{ $i <= $post->my_rating ? 'active' : '' }}">★</button>
                                    @endfor
                                </div>
                            </form>
                        @else
                            <div class="static-stars {{ $post->rating_avg > 0 ? '' : 'inactive' }}">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= round($post->rating_avg) ? '★' : '☆' }}
                                @endfor
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div style="padding:40px; background:rgba(40,40,40,0.6); border-radius:12px; text-align:center; color:#aaa; border:1px solid rgba(255,255,255,0.05);">
                No posts available in the feed.
            </div>
        @endforelse

        <div style="margin-top:20px; text-align: center;">
            {{ $posts->links() }}
        </div>
    </div>

    <!-- Bottom Wave -->
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

    <!-- Background Mouse Interaction Script -->
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