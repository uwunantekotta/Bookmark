<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Audiobook</title>

<link href="https://fonts.cdnfonts.com/css/formula1-display" rel="stylesheet">

<style>
:root {
    font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
    color: #fff;
}

body {
    margin: 0;
    min-height: 100vh;
    background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%);
    overflow-x: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
}

body::before {
    content: "";
    position: fixed;
    inset: 0;
    background-size: cover;
    opacity: 0.25;
    pointer-events: none;
}

/* NAVBAR */
nav {
    width: 100%;
    padding: 22px 50px;
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    z-index: 10;
}

.nav-left {
    display: flex;
    align-items: center;
    gap: 20px; /* space between logo and links */
}

/* Links next to logo */
.nav-links {
    display: flex;
    gap: 20px;
    font-size: 16px;
    align-items: center;
}

.nav-links a, .nav-links form button {
    text-decoration: none;
    color: #fff;
    font-weight: 500;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    font-size: 16px;
    transition: 0.2s;
}

.nav-links a:hover, .nav-links form button:hover {
    opacity: 0.75;
}

/* HERO */
.hero-wrapper {
    flex: 1;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 80px; /* space for navbar */
}

.hero {
    text-align: center;
    max-width: 650px;
    padding: 20px;
    z-index: 1;
}

h1 {
    font-family: 'Formula1 Display', sans-serif;
    font-size: 80px;
    margin-bottom: 10px;
    font-weight: 700;
}

.subtitle {
    font-size: 22px;
    opacity: 0.9;
    margin-bottom: 20px;
}

p {
    font-size: 15px;
    opacity: 0.85;
    margin-bottom: 30px;
    line-height: 1.5;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

a.btn, button.btn {
    text-decoration: none;
    cursor: pointer;
    border-radius: 50px;
    padding: 12px 26px;
    font-size: 16px;
    border: none;
    transition: 0.2s;
}

.btn-primary {
    background: #fff;
    color: #0057ff !important;
    font-weight: 600;
}

.btn-primary:hover {
    background: #eaeaea;
}

.btn-ghost {
    background: rgba(255,255,255,0.25);
    color: #fff !important;
    border: 1px solid rgba(255,255,255,0.3);
    backdrop-filter: blur(4px);
}

.btn-ghost:hover {
    background: rgba(255,255,255,0.35);
}

.cta {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav>
    <div class="nav-left">
        <svg class="logo-icon" viewBox="0 0 24 24" fill="white">
            <path d="M12 3c-4.97 0-9 3.582-9 8v6a3 3 0 003 3h1a2 2 0 002-2v-5a2 2 0 00-2-2H6c0-3.326 3.134-6 7-6s7 2.674 7 6h-1a2 2 0 00-2 2v5a2 2 0 002 2h1a3 3 0 003-3v-6c0-4.418-4.03-8-9-8z"/>
        </svg>
        AUDIOBOOK

        <div class="nav-links">
            <a href="{{ url('/welcome') }}">Home</a>
            @auth
                <a href="{{ url('/welcome_clean') }}">Add Bookmark</a>
                <form action="{{ url('/logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-ghost">Logout</button>
                </form>
            @else
                <a href="{{ url('/login') }}">Add Bookmark</a>
                <a href="{{ url('/register') }}">Register</a>
            @endauth
            <a href="{{ url('/bookmarks') }}">Bookmarks</a>
        </div>
    </div>
</nav>

<!-- HERO SECTION -->
<div class="hero-wrapper">
    <div class="hero">
        <h1>Welcome</h1>
        <div class="subtitle">To Audiobook</div>

        <p>Quickly save, search and open your favorite links — stored in your account and synced across your devices when signed in.</p>

        <div class="cta">
            @auth
                <a class="btn btn-primary" href="{{ url('/welcome_clean') }}">Open Bookmarks</a>

                <form action="{{ url('/logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-ghost" type="submit">Logout</button>
                </form>
            @else
                <a class="btn btn-primary" href="{{ url('/login') }}">Sign in</a>
                <a class="btn btn-ghost" href="{{ url('/register') }}">Register</a>
            @endauth
        </div>
    </div>
</div>

</body>
</html>
