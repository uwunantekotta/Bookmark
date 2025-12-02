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

body::before {
    content: "";
    position: fixed;
    inset: 0;
    background:
    background-size: cover;
    opacity: 0.2;
    pointer-events: none;
}

/* LOGO LINK ANIMATION */
.logo a {
    text-decoration: none;
    color: inherit;
    position: relative;
    transition: 0.25s ease;
}
.logo a::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -4px;
    width: 0%;
    height: 2px;
    background: #fff;
    transition: 0.25s ease;
    border-radius: 50px;
}
.logo a:hover {
    color: #00f0ff;
    letter-spacing: 0.5px;
}
.logo a:hover::after {
    width: 100%;
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

.user-info {
    text-align: right;
    font-size: 13px;
}

.user-info strong { font-weight: 700; }

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
    z-index: 1;
    padding: 0 18px;
}

/* LEFT COLUMN */
.column-left {
    flex: 1;
}

.card {
    width: 100%;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    padding: 24px 18px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    display: flex;
    flex-direction: column;
    align-items: center;
}

.card h2 {
    font-family: 'Formula1 Display', sans-serif;
    font-size: 24px;
    margin-bottom: 6px;
    text-align: center;
}

.card p {
    font-size: 13px;
    opacity: 0.85;
    margin-bottom: 16px;
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
    outline: none;
    transition: 0.2s;
}

input:focus {
    border-color: #00f0ff;
    background: rgba(255,255,255,0.15);
}

.btn {
    padding: 12px 20px;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    transition: 0.2s;
}

.btn-primary { background: #fff; color: #0057ff; }
.btn-primary:hover { background: #eaeaea; }

.btn-ghost { background: rgba(255,255,255,0.25); color: #fff; border:1px solid rgba(255,255,255,0.3); }
.btn-ghost:hover { background: rgba(255,255,255,0.35); }

/* RIGHT COLUMN */
.column-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.2);
    border-radius: 8px;
    background: rgba(255,255,255,0.05);
    transition: 0.2s;
}

.item:hover { background: rgba(255,255,255,0.1); }

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

.actions {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}

#alert {
    margin-top: 12px;
    font-size: 13px;
    text-align: center;
    min-height: 18px;
}

.small {
    font-size: 13px;
    opacity: 0.8;
    margin-top: 14px;
    text-align: center;
}
</style>
</head>
<body>

<header>
    <h1 class="logo">
        <a href="{{ route('welcome') }}">Audiobook</a>
    </h1>

    <div style="display:flex;align-items:center;gap:12px">
        @auth
            <div class="user-info">
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
    <!-- LEFT: Add bookmark -->
    <div class="column-left">
        <div class="card">
            <h2>Add Music Bookmark</h2>
            <p>Save songs, album pages, artist pages, and streaming links for later.</p>

            <form id="addForm" enctype="multipart/form-data" style="width:100%; display:flex; flex-direction:column; gap:8px;">
                <input type="text" id="title" placeholder="Song title (optional)">
                <input type="text" id="artist" placeholder="Artist (required)" required>
                <input type="url" id="url" placeholder="https://open.spotify.com/track/..." required>
                <label for="image" style="font-size:13px; opacity:0.8;">Attach photo (optional)</label>
                <input type="file" id="image" accept="image/*">

                <div style="display:flex; gap:8px; justify-content:center; margin-top:4px;">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" id="clearAll" class="btn btn-ghost">Clear all</button>
                </div>
            </form>

            <input type="text" id="q" placeholder="Search bookmarks..." style="margin-top:12px; width:100%; padding:12px 14px; border-radius:8px; border:1px solid rgba(255,255,255,0.4); background: rgba(255,255,255,0.1); color:#fff; outline:none; font-size:15px;">

            <div id="alert" role="status"></div>
        </div>
    </div>

    <!-- RIGHT: Bookmarked songs -->
    <div class="column-right" id="list"></div>
</main>

<div class="small">Bookmarks are saved to your account and synced across devices when signed in.</div>

<script>
// JS logic remains the same from your previous script
</script>

</body>
</html>

