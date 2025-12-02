<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feed — Audiobook</title>
    <link href="https://fonts.cdnfonts.com/css/formula1-display" rel="stylesheet">
    <style>
        body { background: #0b1a2b; color:#fff; font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; margin:0; padding:20px; }
        .container { max-width:900px; margin:0 auto; }
        header { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; }
        h1 { font-family:'Formula1 Display', sans-serif; }
        .post { background: rgba(255,255,255,0.03); padding:12px; border-radius:10px; margin-bottom:12px; display:flex; gap:12px; }
        .avatar { width:56px; height:56px; border-radius:50%; background:#222; display:flex; align-items:center; justify-content:center; font-weight:700; }
        .post-body { flex:1; }
        .title { font-weight:800; }
        .meta { font-size:13px; color:#bdbdbd; margin-top:6px; }
        .post img.media { width:92px; height:92px; border-radius:8px; object-fit:cover; }
        .role-badge { padding:4px 8px; border-radius:8px; font-size:12px; font-weight:700; }
        .role-badge.admin { background:#ffdddd; color:#c00; }
        .role-badge.contributor { background:#fff4dd; color:#b25a00; }
        .role-badge.viewer { background:#ddffea; color:#007a3d; }
        .actions { margin-top:8px; display: flex; justify-content: space-between; align-items: flex-end; }
        .btn { padding:8px 12px; border-radius:8px; border:none; cursor:pointer; font-weight:700; text-decoration: none; font-size: 13px; }
        .btn-ghost { background: rgba(255,255,255,0.06); color:#fff; }
        .btn-approve { background:#2ecc71; color:#042; }
        .btn-reject { background:#e74c3c; color:#fff; }

        /* STAR RATING CSS */
        .star-group { display: inline-flex; flex-direction: row; }
        .star-btn { background: none; border: none; cursor: pointer; font-size: 18px; color: #444; padding: 0 1px; transition: color 0.2s; }
        .star-btn:hover, .star-btn:hover ~ .star-btn { color: #444; } /* Reset */
        .star-group:hover .star-btn { color: #00f0ff; } /* Highlight all on hover */
        .star-btn:hover ~ .star-btn { color: #444; } /* Grey out stars after cursor */
        .star-btn.active { color: #ffaa00; } /* Gold for active rating */
        .rating-wrapper { text-align: right; }
        .rating-stats { font-size: 11px; color: #888; margin-bottom: 2px; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Feed</h1>
            <nav>
                <a href="{{ route('welcome_clean') }}" style="color:#fff; text-decoration:none; margin-right:12px;">Home</a>
                <a href="{{ route('bookmarks') }}" style="color:#fff; text-decoration:none; margin-right:12px;">Add</a>
                <a href="{{ route('feed') }}" style="color:#00f0ff; text-decoration:none;">Feed</a>
            </nav>
        </header>

        @forelse($posts as $post)
            <div class="post">
                <div class="avatar">{{ strtoupper(substr($post->user->name ?? 'U',0,1)) }}</div>

                <div class="post-body">
                    <div style="display:flex; gap:8px; align-items:center;">
                        <div style="flex:1">
                            <div class="title">{{ $post->title ?? ($post->artist ? $post->artist : 'Untitled') }}</div>
                            <div class="meta">by <strong>{{ $post->user->name ?? 'Unknown' }}</strong>
                                @if(isset($post->user->role))
                                    <span style="margin-left:8px;" class="role-badge {{ $post->user->role }}">{{ ucfirst($post->user->role) }}</span>
                                @endif
                            </div>
                        </div>

                        @if($post->image)
                            <img class="media" src="{{ asset('storage/' . $post->image) }}" alt="media">
                        @else
                            <img class="media" src="https://via.placeholder.com/92?text=Audio" alt="media">
                        @endif
                    </div>

                    <div class="meta" style="margin-top:8px;">
                        @if($post->artist) {{ $post->artist }} · @endif
                        @if($post->genre) <em>{{ $post->genre }}</em> · @endif
                        Uploaded: {{ $post->uploaded_at ? \Carbon\Carbon::parse($post->uploaded_at)->format('M j, Y') : 'Unknown' }}
                    </div>

                    <div class="actions">
                        <div>
                            <a class="btn btn-ghost" href="{{ $post->url }}" target="_blank">Open</a>

                            @auth
                                @if(auth()->user()->isAdmin() && $post->type === 'music' && isset($post->status) && $post->status === 'pending')
                                    <form method="POST" action="{{ route('admin.music.approve', $post->id) }}" style="display:inline">@csrf
                                        <button class="btn btn-approve" type="submit">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.music.reject', $post->id) }}" style="display:inline; margin-left:8px;">@csrf
                                        <button class="btn btn-reject" type="submit">Reject</button>
                                    </form>
                                @endif
                            @endauth
                        </div>

                        <div class="rating-wrapper">
                            <div class="rating-stats">
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
                                <div style="font-size:14px; color:#444;">★ ★ ★ ★ ★</div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div style="padding:20px; background:rgba(255,255,255,0.03); border-radius:8px; text-align:center; color:#aaa;">No posts available in the feed.</div>
        @endforelse

        <div style="margin-top:12px;">{{ $posts->links() }}</div>
    </div>
</body>
</html>