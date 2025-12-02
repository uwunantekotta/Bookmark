<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Posts – Admin</title>
    <link href="https://fonts.cdnfonts.com/css/formula1-display" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        :root { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; color: #fff; --move-x: 0px; --move-y: 0px; }
        
        body { 
            margin: 0; 
            min-height: 100vh; 
            padding: 20px; 
            position: relative;
            overflow-x: hidden;
        }

        /* --- BACKGROUND STYLES --- */
        .bg-layer { position: fixed; inset: 0; width: 100%; height: 100%; pointer-events: none; }
        .bg-blue { background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%); z-index: -10; }
        .bg-gray { background: linear-gradient(135deg, #2b2b2b 0%, #3a3a3a 60%, #4f4f4f 100%); z-index: -9; opacity: 0; animation: fadeCycle 15s infinite ease-in-out; }
        @keyframes fadeCycle { 0%, 40% { opacity: 0; } 50%, 90% { opacity: 1; } 100% { opacity: 0; } }

        body::before {
            content: ""; position: fixed; inset: -5%; width: 110%; height: 110%; z-index: -4;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 800'%3E%3Cpath fill='%23ffffff' fill-opacity='0.05' d='M0,256L48,261.3C96,267,192,277,288,293.3C384,309,480,331,576,314.7C672,299,768,245,864,245.3C960,245,1056,299,1152,298.7C1248,299,1344,245,1392,218.7L1440,192L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,416L48,421.3C96,427,192,437,288,421.3C384,405,480,363,576,362.7C672,363,768,405,864,432C960,459,1056,469,1152,448C1248,427,1344,373,1392,346.7L1440,320L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.15' d='M0,576L48,586.7C96,597,192,619,288,602.7C384,587,480,533,576,512C672,491,768,501,864,528C960,555,1056,597,1152,597.3C1248,597,1344,555,1392,533.3L1440,512L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover; background-position: center bottom; opacity: 0.4; pointer-events: none;
            transform: translate(var(--move-x), var(--move-y)); transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* WAVE ANIMATIONS */
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
        .container { max-width: 1000px; margin: 0 auto; position: relative; z-index: 1; }
        
        header { 
            background: rgba(0, 0, 0, 0.55); 
            backdrop-filter: blur(8px); 
            padding: 20px 30px; 
            border-radius: 16px; 
            margin-bottom: 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }
        
        h1 { font-family: 'Formula1 Display', sans-serif; font-size: 28px; margin: 0; }
        
        .back-btn { 
            background: #00f0ff; 
            color: #000; 
            border: none; 
            padding: 10px 20px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 600; 
            text-decoration: none; 
            display: inline-block; 
            transition: 0.2s; 
        }
        .back-btn:hover { background: #00d4e8; }
        
        .section-title { 
            font-size: 18px; 
            margin: 30px 0 15px; 
            border-bottom: 1px solid rgba(255,255,255,0.2); 
            padding-bottom: 10px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .badge-count { 
            background: #ff4444; 
            color: white; 
            padding: 2px 8px; 
            border-radius: 10px; 
            font-size: 12px; 
            font-weight: bold; 
        }

        /* Card Styles with Left Borders */
        .post-card { 
            background: rgba(0, 0, 0, 0.55); 
            backdrop-filter: blur(8px); 
            border-radius: 12px; 
            padding: 15px; 
            margin-bottom: 15px; 
            display: flex; 
            gap: 15px; 
            border-left: 4px solid #44dd44; /* Default border color */
            transition: 0.2s; 
        }
        .post-card:hover { transform: translateY(-2px); background: rgba(0, 0, 0, 0.65); }
        .post-card.pending { border-left-color: #ffaa00; background: rgba(255, 170, 0, 0.15); }
        .post-card.bookmark { border-left-color: #00f0ff; }
        .post-card.music { border-left-color: #44dd44; }

        .media-preview { 
            width: 80px; 
            height: 80px; 
            background: rgba(255, 255, 255, 0.1); 
            border-radius: 8px; 
            overflow: hidden; 
            flex-shrink: 0; 
        }
        .media-preview img { width: 100%; height: 100%; object-fit: cover; }
        
        .post-content { flex: 1; }
        .post-title { font-weight: 700; font-size: 16px; margin: 0 0 4px; }
        .post-meta { font-size: 13px; color: #ccc; margin-bottom: 4px; }
        .post-user { font-size: 12px; color: #aaa; }
        
        .post-actions { 
            display: flex; 
            flex-direction: column; 
            gap: 6px; 
            justify-content: center; 
            min-width: 120px; 
        }

        /* Buttons */
        .btn { 
            padding: 8px 12px; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 12px; 
            font-weight: 600; 
            transition: 0.2s; 
            text-align: center; 
            text-decoration: none; 
            display: block; 
            width: 100%; 
        }
        .btn-approve { background: #44dd44; color: #003300; }
        .btn-approve:hover { background: #33cc33; }
        .btn-reject { background: #ff4444; color: white; }
        .btn-reject:hover { background: #cc0000; }
        .btn-delete { background: rgba(255, 68, 68, 0.2); color: #ffcccc; border: 1px solid rgba(255, 68, 68, 0.4); }
        .btn-delete:hover { background: rgba(255, 68, 68, 0.4); color: #fff; }
        .btn-link { background: rgba(255, 255, 255, 0.1); color: #fff; }
        .btn-link:hover { background: rgba(255, 255, 255, 0.2); }

        .type-badge { 
            font-size: 10px; 
            text-transform: uppercase; 
            padding: 2px 6px; 
            border-radius: 4px; 
            background: rgba(255,255,255,0.1); 
            margin-right: 6px; 
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
            <h1>Manage Posts</h1>
            <a href="{{ route('admin.dashboard') }}" class="back-btn">← Dashboard</a>
        </header>

        @if(session('success'))
            <div style="background: rgba(68, 221, 68, 0.2); border: 1px solid #44dd44; color: #aaffaa; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($pendingMusic->count() > 0)
            <div class="section-title" style="color: #ffaa00;">
                ⚠ Pending Approvals <span class="badge-count">{{ $pendingMusic->count() }}</span>
            </div>
            @foreach($pendingMusic as $music)
                <div class="post-card pending">
                    <div class="media-preview">
                        @if($music->image_path)
                            <img src="{{ asset('storage/' . $music->image_path) }}">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">🎵</div>
                        @endif
                    </div>
                    <div class="post-content">
                        <div class="post-title">{{ $music->title ?: 'Untitled' }}</div>
                        <div class="post-meta">{{ $music->artist }}</div>
                        <div class="post-user">Uploaded by: <strong>{{ $music->user->name }}</strong></div>
                        <div style="font-size:11px; margin-top:4px; opacity:0.7;">{{ $music->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="post-actions">
                        <form method="POST" action="{{ route('admin.posts.approve', $music->id) }}">
                            @csrf
                            <button class="btn btn-approve">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.posts.reject', $music->id) }}">
                            @csrf
                            <button class="btn btn-reject" onclick="const reason=prompt('Reason for rejection?'); if(reason===null) return false; this.form.insertAdjacentHTML('beforeend', `<input type='hidden' name='rejection_reason' value='${reason}'>`);">Reject</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="section-title">
            All Published Posts
        </div>

        @forelse($posts as $post)
            <div class="post-card {{ $post->type }}">
                <div class="media-preview">
                    @php $img = $post->type === 'music' ? $post->image_path : $post->image; @endphp
                    @if($img)
                        <img src="{{ asset('storage/' . $img) }}">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:24px;">
                            {{ $post->type === 'music' ? '🎵' : '🔖' }}
                        </div>
                    @endif
                </div>
                <div class="post-content">
                    <div class="post-title">
                        <span class="type-badge">{{ ucfirst($post->type) }}</span>
                        {{ $post->title ?: ($post->artist ?? 'Untitled') }}
                    </div>
                    <div class="post-meta">{{ $post->artist }}</div>
                    <div class="post-meta"><a href="{{ $post->url }}" target="_blank" style="color:#00f0ff;text-decoration:none;">{{ Str::limit($post->url, 40) }}</a></div>
                    <div class="post-user">Posted by: {{ $post->user->name ?? 'Unknown' }} • {{ $post->created_at->format('M d, Y') }}</div>
                </div>
                <div class="post-actions">
                    <a href="{{ $post->url }}" target="_blank" class="btn btn-link">View</a>
                    <form method="POST" action="{{ route('admin.posts.destroy', ['type' => $post->type, 'id' => $post->id]) }}" onsubmit="return confirm('Permanently delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-delete">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:40px; color:#aaa;">No posts found.</div>
        @endforelse

        <div style="margin-top:20px;">
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