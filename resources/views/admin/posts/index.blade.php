<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Posts – Admin</title>
    <link href="https://fonts.cdnfonts.com/css/formula1-display" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        :root { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; color: #fff; }
        body { margin: 0; min-height: 100vh; background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%); padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; }
        header { background: rgba(0, 0, 0, 0.55); backdrop-filter: blur(8px); padding: 20px 30px; border-radius: 16px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        h1 { font-family: 'Formula1 Display', sans-serif; font-size: 28px; margin: 0; }
        .back-btn { background: #00f0ff; color: #000; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; transition: 0.2s; }
        .back-btn:hover { background: #00d4e8; }
        
        .section-title { font-size: 18px; margin: 30px 0 15px; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 10px; display: flex; align-items: center; gap: 10px; }
        .badge-count { background: #ff4444; color: white; padding: 2px 8px; border-radius: 10px; font-size: 12px; font-weight: bold; }

        /* Card Styles */
        .post-card { background: rgba(0, 0, 0, 0.55); backdrop-filter: blur(8px); border-radius: 12px; padding: 15px; margin-bottom: 15px; display: flex; gap: 15px; border-left: 4px solid #44dd44; transition: 0.2s; }
        .post-card:hover { transform: translateY(-2px); background: rgba(0, 0, 0, 0.65); }
        .post-card.pending { border-left-color: #ffaa00; background: rgba(255, 170, 0, 0.15); }
        .post-card.bookmark { border-left-color: #00f0ff; }
        .post-card.music { border-left-color: #44dd44; }

        .media-preview { width: 80px; height: 80px; background: rgba(255, 255, 255, 0.1); border-radius: 8px; overflow: hidden; flex-shrink: 0; }
        .media-preview img { width: 100%; height: 100%; object-fit: cover; }
        .post-content { flex: 1; }
        .post-title { font-weight: 700; font-size: 16px; margin: 0 0 4px; }
        .post-meta { font-size: 13px; color: #ccc; margin-bottom: 4px; }
        .post-user { font-size: 12px; color: #aaa; }
        .post-actions { display: flex; flex-direction: column; gap: 6px; justify-content: center; min-width: 120px; }

        /* Buttons */
        .btn { padding: 8px 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600; transition: 0.2s; text-align: center; text-decoration: none; display: block; width: 100%; }
        .btn-approve { background: #44dd44; color: #003300; }
        .btn-approve:hover { background: #33cc33; }
        .btn-reject { background: #ff4444; color: white; }
        .btn-reject:hover { background: #cc0000; }
        .btn-delete { background: rgba(255, 68, 68, 0.2); color: #ffcccc; border: 1px solid rgba(255, 68, 68, 0.4); }
        .btn-delete:hover { background: rgba(255, 68, 68, 0.4); color: #fff; }
        .btn-link { background: rgba(255, 255, 255, 0.1); color: #fff; }
        .btn-link:hover { background: rgba(255, 255, 255, 0.2); }

        .type-badge { font-size: 10px; text-transform: uppercase; padding: 2px 6px; border-radius: 4px; background: rgba(255,255,255,0.1); margin-right: 6px; }
    </style>
</head>
<body>
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
</body>
</html>