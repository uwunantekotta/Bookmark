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
    justify-content: center;
    z-index: 10;
}

.nav-left {
    display: flex;
    align-items: center;
    gap: 20px; /* space between logo and links */
}

/* New class for the Brand Name */
.brand-name {
    font-family: 'Formula1 Display', sans-serif;
    font-size: 22px; 
    font-weight: 700;
    letter-spacing: 0.5px;
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
    white-space: nowrap;
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
    line-height: 1.1;
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

/* ROLLING TEXT ANIMATION */
.reveal-text {
    display: inline-flex;
    overflow: hidden;
    vertical-align: bottom;
    line-height: 1.2;
}

.reveal-text span {
    display: block;
    transform: translateY(110%);
    animation: rollUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Animation Delay Utility */
.delay-1 { animation-delay: 0.15s; }
.delay-2 { animation-delay: 0.3s; }

@keyframes rollUp {
    0% {
        transform: translateY(110%);
    }
    100% {
        transform: translateY(0);
    }
}

/* BUTTON STYLES & ANIMATIONS */
a.btn, button.btn {
    text-decoration: none;
    cursor: pointer;
    border-radius: 50px;
    padding: 12px 26px;
    font-size: 16px;
    border: none;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    position: relative;
    display: inline-block;
}

a.btn:hover, button.btn:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.btn-primary {
    background: #fff;
    color: #0057ff !important;
    font-weight: 600;
}

.btn-primary:hover {
    background: #f0f0f0;
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
        
        <span class="brand-name">AUDIOBOOK</span>

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
            @endauth
            <a href="{{ url('/bookmarks') }}">Bookmarks</a>
        </div>
    </div>
</nav>

<!-- HERO SECTION -->
<div class="hero-wrapper">
    <div class="hero">
        <!-- Rolling Text for H1 -->
        <h1>
            <span class="reveal-text">
                <span>Welcome</span>
            </span>
        </h1>
        
        <!-- Rolling Text for Subtitle (with delay) -->
        <div class="subtitle">
            <span class="reveal-text">
                <span class="delay-1">To Audiobook</span>
            </span>
        </div>

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