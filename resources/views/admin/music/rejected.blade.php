<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rejected Songs – Admin</title>
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
            border-left: 4px solid #ff4444;
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

        .rejection-reason {
            background: rgba(255, 68, 68, 0.1);
            border-left: 3px solid #ff4444;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
            font-size: 13px;
            color: #ffdddd;
        }

        .rejection-reason-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .empty-message {
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(8px);
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Rejected Songs</h1>
            <a href="{{ route('admin.dashboard') }}" class="back-btn">← Back to Dashboard</a>
        </header>

        @forelse($rejectedMusic as $music)
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
                    
                    @if($music->rejection_reason)
                        <div class="rejection-reason">
                            <div class="rejection-reason-title">Rejection Reason:</div>
                            {{ $music->rejection_reason }}
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-message">
                <p>No rejected songs</p>
            </div>
        @endforelse
    </div>
</body>
</html>
