<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music Approval – Admin</title>
    <link href="https://fonts.cdnfonts.com/css/formula1-display" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
            color: #fff;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%);
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

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

        h1 {
            font-family: 'Formula1 Display', sans-serif;
            font-size: 28px;
            margin: 0;
        }

        h2 {
            font-size: 18px;
            margin-top: 30px;
            margin-bottom: 15px;
            color: #ffaa00;
        }

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

        .back-btn:hover {
            background: #00d4e8;
        }

        .music-card {
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(8px);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            border-left: 4px solid #ffaa00;
        }

        .music-image {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .music-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .music-content {
            flex: 1;
        }

        .music-title {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 5px;
        }

        .music-info {
            font-size: 13px;
            color: #aaa;
            margin: 3px 0;
        }

        .uploader {
            margin-top: 10px;
            font-size: 12px;
            color: #888;
        }

        .music-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px;
        }

        .btn-approve, .btn-reject {
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: 0.2s;
        }

        .btn-approve {
            background: #44dd44;
            color: #000;
        }

        .btn-approve:hover {
            background: #2fb82f;
        }

        .btn-reject {
            background: #ff4444;
            color: white;
        }

        .btn-reject:hover {
            background: #cc0000;
        }

        .reject-form {
            display: none;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .reject-form.active {
            display: block;
        }

        .reject-form textarea {
            width: 100%;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            color: #fff;
            font-size: 12px;
            margin-bottom: 10px;
            max-height: 80px;
            resize: vertical;
        }

        .reject-form textarea::placeholder {
            color: #777;
        }

        .reject-submit {
            background: #ff4444;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
        }

        .reject-submit:hover {
            background: #cc0000;
        }

        .empty-message {
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(8px);
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            color: #aaa;
        }

        .success-message {
            background: rgba(68, 221, 68, 0.1);
            border-left: 4px solid #44dd44;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-size: 13px;
            color: #aaffaa;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Music Approval</h1>
            <a href="{{ route('admin.dashboard') }}" class="back-btn">← Back to Dashboard</a>
        </header>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <h2>⏳ Pending Songs</h2>
        
        @forelse($pendingMusic as $music)
            <div class="music-card">
                <div class="music-image">
                    @if($music->image_path)
                        <img src="{{ asset('storage/' . $music->image_path) }}" alt="{{ $music->title }}">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 40px;">🎵</div>
                    @endif
                </div>
                <div class="music-content">
                    <p class="music-title">{{ $music->title ?: 'Untitled' }}</p>
                    <p class="music-info"><strong>Artist:</strong> {{ $music->artist }}</p>
                    <p class="music-info"><strong>URL:</strong> <a href="{{ $music->url }}" target="_blank" style="color: #00f0ff;">{{ Str::limit($music->url, 50) }}</a></p>
                    <p class="uploader">Uploaded by: <strong>{{ $music->user->name }}</strong> ({{ $music->user->email }})</p>
                    <p class="uploader">{{ $music->created_at->format('M d, Y H:i A') }}</p>
                </div>
                <div class="music-actions">
                    <form method="POST" action="{{ route('admin.music.approve', $music->id) }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-approve">✓ Approve</button>
                    </form>
                    <button type="button" class="btn-reject" onclick="toggleRejectForm({{ $music->id }})">✗ Reject</button>
                    <div id="reject-form-{{ $music->id }}" class="reject-form">
                        <form method="POST" action="{{ route('admin.music.reject', $music->id) }}">
                            @csrf
                            <textarea name="rejection_reason" placeholder="Optional: Reason for rejection..."></textarea>
                            <button type="submit" class="reject-submit">Submit Rejection</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-message">
                <p>No pending songs for approval</p>
            </div>
        @endforelse

        <h2>✓ Approved Songs</h2>

        @forelse($approvedMusic as $music)
            <div class="music-card" style="border-left-color: #44dd44;">
                <div class="music-image">
                    @if($music->image_path)
                        <img src="{{ asset('storage/' . $music->image_path) }}" alt="{{ $music->title }}">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 40px;">🎵</div>
                    @endif
                </div>
                <div class="music-content">
                    <p class="music-title">{{ $music->title ?: 'Untitled' }}</p>
                    <p class="music-info"><strong>Artist:</strong> {{ $music->artist }}</p>
                    <p class="music-info"><strong>URL:</strong> <a href="{{ $music->url }}" target="_blank" style="color: #00f0ff;">{{ Str::limit($music->url, 50) }}</a></p>
                    <p class="uploader">Uploaded by: <strong>{{ $music->user->name }}</strong> ({{ $music->user->email }})</p>
                    <p class="uploader">{{ $music->created_at->format('M d, Y H:i A') }}</p>
                </div>
                <div style="padding: 20px; text-align: center; color: #44dd44; font-weight: 600;">
                    ✓ APPROVED
                </div>
            </div>
        @empty
            <div class="empty-message">
                <p>No approved songs yet</p>
            </div>
        @endforelse
    </div>

    <script>
        function toggleRejectForm(musicId) {
            const form = document.getElementById(`reject-form-${musicId}`);
            form.classList.toggle('active');
        }
    </script>
</body>
</html>
