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
    /* Added SVG Wavy Background */
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 800'%3E%3Cpath fill='%23ffffff' fill-opacity='0.05' d='M0,256L48,261.3C96,267,192,277,288,293.3C384,309,480,331,576,314.7C672,299,768,245,864,245.3C960,245,1056,299,1152,298.7C1248,299,1344,245,1392,218.7L1440,192L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,416L48,421.3C96,427,192,437,288,421.3C384,405,480,363,576,362.7C672,363,768,405,864,432C960,459,1056,469,1152,448C1248,427,1344,373,1392,346.7L1440,320L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.15' d='M0,576L48,586.7C96,597,192,619,288,602.7C384,587,480,533,576,512C672,491,768,501,864,528C960,555,1056,597,1152,597.3C1248,597,1344,555,1392,533.3L1440,512L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3C/svg%3E");
    background-size: cover;
    background-position: center bottom;
    opacity: 0.4; /* Adjusted opacity to make the pattern visible but subtle */
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
    justify-content: flex-start;
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
    display: flex; 
    align-items: center;
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
    line-height: inherit; /* inherit line-height to fix paragraph spacing */
}

.reveal-text span {
    display: block;
    transform: translateY(110%);
    animation: rollUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Animation Delay Utility */
.delay-1 { animation-delay: 0.15s; }
.delay-2 { animation-delay: 0.3s; }
.delay-3 { animation-delay: 0.45s; } /* Delay for buttons */

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
    display: inline-flex; /* Use inline-flex to center content */
    align-items: center;
    justify-content: center;
    height: 48px; /* Fixed height to prevent layout shifts during animation */
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
        <!-- Logo Icon -->
        <svg class="logo-icon" viewBox="0 0 24 24" fill="white" style="width: 24px; height: 24px;">
            <path d="M12 3c-4.97 0-9 3.582-9 8v6a3 3 0 003 3h1a2 2 0 002-2v-5a2 2 0 00-2-2H6c0-3.326 3.134-6 7-6s7 2.674 7 6h-1a2 2 0 00-2 2v5a2 2 0 002 2h1a3 3 0 003-3v-6c0-4.418-4.03-8-9-8z"/>
        </svg>
        
        <!-- Brand Name with Rolling Animation -->
        <span class="brand-name">
            <span class="reveal-text">
                <span>AUDIOBOOK</span>
            </span>
        </span>

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
        
        <!-- Rolling Text for Subtitle (with delay 1) -->
        <div class="subtitle">
            <span class="reveal-text">
                <span class="delay-1">To Audiobook</span>
            </span>
        </div>

        <!-- Rolling Text for Paragraph (with delay 2) -->
        <p>
            <span class="reveal-text">
                <span class="delay-2">Quickly save, search and open your favorite links — stored in your account and synced across your devices when signed in.</span>
            </span>
        </p>

        <div class="cta">
            @auth
                <a class="btn btn-primary" href="{{ url('/welcome_clean') }}">
                    <span class="reveal-text">
                        <span class="delay-3">Open Bookmarks</span>
                    </span>
                </a>

                <form action="{{ url('/logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-ghost" type="submit">
                        <span class="reveal-text">
                            <span class="delay-3">Logout</span>
                        </span>
                    </button>
                </form>
            @else
                <a class="btn btn-primary" href="{{ url('/login') }}">
                    <span class="reveal-text">
                        <span class="delay-3">Sign in</span>
                    </span>
                </a>
                <a class="btn btn-ghost" href="{{ url('/register') }}">
                    <span class="reveal-text">
                        <span class="delay-3">Register</span>
                    </span>
                </a>
            @endauth
        </div>
    </div>
</div>

</body>
</html>