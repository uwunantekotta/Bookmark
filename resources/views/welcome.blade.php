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
    /* Initialize CSS variables for mouse interaction */
    --move-x: 0px;
    --move-y: 0px;
}

body {
    margin: 0;
    min-height: 100vh;
    /* Removed static background here, moved to .bg-blue layer */
    overflow-x: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

/* Background Color Layers */
.bg-layer {
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.bg-blue {
    background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%);
    z-index: -10; /* Lowest layer */
}

.bg-gray {
    background: linear-gradient(135deg, #2b2b2b 0%, #3a3a3a 60%, #4f4f4f 100%); /* Minimalistic Dark Gray */
    z-index: -9; /* On top of blue */
    opacity: 0;
    /* Increased duration to 15s (7.5s per phase) */
    animation: fadeCycle 15s infinite ease-in-out;
}

@keyframes fadeCycle {
    0%, 40% { opacity: 0; }      /* Blue Visible */
    50%, 90% { opacity: 1; }     /* Gray Visible */
    100% { opacity: 0; }         /* Back to Blue */
}

/* Button Color Animation */
@keyframes colorCycle {
    0%, 40% { color: #0057ff; }  /* Blue Text */
    50%, 90% { color: #2b2b2b; } /* Gray Text */
    100% { color: #0057ff; }     /* Back to Blue */
}

body::before {
    content: "";
    position: fixed;
    /* Expanded size to allow movement without showing edges */
    inset: -5%;
    width: 110%;
    height: 110%;
    z-index: -4; /* Above colors, below waves */
    
    /* SVG Wavy Background Texture */
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 800'%3E%3Cpath fill='%23ffffff' fill-opacity='0.05' d='M0,256L48,261.3C96,267,192,277,288,293.3C384,309,480,331,576,314.7C672,299,768,245,864,245.3C960,245,1056,299,1152,298.7C1248,299,1344,245,1392,218.7L1440,192L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,416L48,421.3C96,427,192,437,288,421.3C384,405,480,363,576,362.7C672,363,768,405,864,432C960,459,1056,469,1152,448C1248,427,1344,373,1392,346.7L1440,320L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.15' d='M0,576L48,586.7C96,597,192,619,288,602.7C384,587,480,533,576,512C672,491,768,501,864,528C960,555,1056,597,1152,597.3C1248,597,1344,555,1392,533.3L1440,512L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3C/svg%3E");
    background-size: cover;
    background-position: center bottom;
    opacity: 0.4; 
    pointer-events: none;
    
    /* Interactive transform props */
    --move-x: 0px;
    --move-y: 0px;
    transform: translate(var(--move-x), var(--move-y));
    transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

/* --- NEW REALISTIC WAVE ANIMATION --- */
.waves-container {
    position: fixed; /* Changed to fixed to guarantee full coverage */
    /* Make container wider than screen to prevent gaps on movement */
    left: -10%;
    width: 120%;
    /* Increased height to maintain visibility despite larger offset */
    height: 50vh; 
    z-index: -1; /* Behind content */
    pointer-events: none;
}

.waves-bottom {
    /* Larger buffer: positions the element 100px below the viewport edge */
    bottom: -100px;
}

.waves-top {
    /* Larger buffer: positions the element 100px above the viewport edge */
    top: -100px;
    transform: rotate(180deg); /* Flip to hang from top */
}

.waves {
    position: relative;
    width: 100%;
    height: 100%;
    margin-bottom: -7px; /* Fix for safari gap */
    min-height: 100px;
    /* Removed max-height to prevent constraint gaps */
    
    /* Interactive Mouse Movement */
    /* We use translate3d to move the waves based on mouse position */
    transform: translate3d(var(--move-x), var(--move-y), 0);
    /* Smooth out the mouse movement */
    transition: transform 0.1s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

/* Animation for the wave movement (flowing water) */
.parallax > use {
    animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
}

.parallax > use:nth-child(1) {
    animation-delay: -2s;
    animation-duration: 7s;
    fill: rgba(255, 255, 255, 0.05); /* Very subtle white */
}
.parallax > use:nth-child(2) {
    animation-delay: -3s;
    animation-duration: 10s;
    fill: rgba(255, 255, 255, 0.1);
}
.parallax > use:nth-child(3) {
    animation-delay: -4s;
    animation-duration: 13s;
    fill: rgba(255, 255, 255, 0.15);
}
.parallax > use:nth-child(4) {
    animation-delay: -5s;
    animation-duration: 20s;
    /* The last wave is slightly more visible to define the "surface" */
    fill: rgba(255, 255, 255, 0.2); 
}

@keyframes move-forever {
    0% {
        transform: translate3d(-90px, 0, 0);
    }
    100% {
        transform: translate3d(85px, 0, 0);
    }
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
    padding-bottom: 120px; /* Added padding to bottom to push the center point UP */
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
    /* Added bold and italic styles */
    font-weight: 700;
    font-style: italic;
}

p {
    font-size: 15px;
    opacity: 0.85;
    margin-bottom: 30px;
    line-height: 1.5;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
    cursor: default; /* Indicates text interaction */
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
    animation: rollUp 1.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; /* Slowed down to 1.5s */
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth hover transition */
}

/* HOVER ANIMATION FOR PARAGRAPH TEXT */
.hero p:hover .reveal-text span {
    transform: translateY(0) scale(1.02); /* Maintain position, slight zoom */
    color: #00f0ff; /* Electric Blue Color */
    text-shadow: 0 0 15px rgba(0, 240, 255, 0.6); /* Neon Glow */
    letter-spacing: 0.5px; /* Slight expansion */
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
}

a.btn:hover, button.btn:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.btn-primary {
    background: #fff;
    color: #0057ff; /* Removed !important to allow animation override */
    font-weight: 600;
    /* Added color transition animation */
    animation: colorCycle 15s infinite ease-in-out;
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

<!-- Background Layers -->
<div class="bg-layer bg-blue"></div>
<div class="bg-layer bg-gray"></div>

<!-- TOP WAVE ANIMATION -->
<div class="waves-container waves-top">
    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
    viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
    <defs>
    <path id="gentle-wave-top" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
    </defs>
    <g class="parallax">
    <use xlink:href="#gentle-wave-top" x="48" y="0" />
    <use xlink:href="#gentle-wave-top" x="48" y="3" />
    <use xlink:href="#gentle-wave-top" x="48" y="5" />
    <use xlink:href="#gentle-wave-top" x="48" y="7" />
    </g>
    </svg>
</div>

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
            <a href="{{ url('/welcome') }}">
                <span class="reveal-text">
                    <span>Home</span>
                </span>
            </a>
            @auth
                <a href="{{ url('/welcome_clean') }}">
                    <span class="reveal-text">
                        <span>Add Bookmark</span>
                    </span>
                </a>
                <form action="{{ url('/logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-ghost">
                        <span class="reveal-text">
                            <span>Logout</span>
                        </span>
                    </button>
                </form>
            @else
                <a href="{{ url('/login') }}">
                    <span class="reveal-text">
                        <span>Add Bookmark</span>
                    </span>
                </a>
            @endauth
            <a href="{{ url('/bookmarks') }}">
                <span class="reveal-text">
                    <span>Bookmarks</span>
                </span>
            </a>
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

<!-- BOTTOM WAVE ANIMATION CONTAINER -->
<div class="waves-container waves-bottom">
    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
    viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
    <defs>
    <path id="gentle-wave-bottom" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
    </defs>
    <g class="parallax">
    <use xlink:href="#gentle-wave-bottom" x="48" y="0" />
    <use xlink:href="#gentle-wave-bottom" x="48" y="3" />
    <use xlink:href="#gentle-wave-bottom" x="48" y="5" />
    <use xlink:href="#gentle-wave-bottom" x="48" y="7" />
    </g>
    </svg>
</div>

<!-- Interactive Background Script -->
<script>
    document.addEventListener('mousemove', (e) => {
        const { clientX, clientY } = e;
        // Divide by 50 to make the movement noticeable but smooth
        // Moving opposite to mouse direction
        const x = (window.innerWidth / 2 - clientX) / 50;
        const y = (window.innerHeight / 2 - clientY) / 50;
        
        // Update CSS variables on the root or body
        document.documentElement.style.setProperty('--move-x', `${x}px`);
        document.documentElement.style.setProperty('--move-y', `${y}px`);
    });
</script>

</body>
</html>