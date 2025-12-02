<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Audiobook – Login</title>

<link href="https://fonts.cdnfonts.com/css/formula1-display" rel="stylesheet">

<style>
    /* GLOBAL BOX SIZING FIX */
    *, *::before, *::after {
        box-sizing: border-box;
    }

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
        display: flex;
        align-items: center;
        justify-content: center;
        overflow-x: hidden;
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
        z-index: -10;
    }

    .bg-gray {
        background: linear-gradient(135deg, #2b2b2b 0%, #3a3a3a 60%, #4f4f4f 100%);
        z-index: -9;
        opacity: 0;
        animation: fadeCycle 15s infinite ease-in-out;
    }

    @keyframes fadeCycle {
        0%, 40% { opacity: 0; }
        50%, 90% { opacity: 1; }
        100% { opacity: 0; }
    }

    /* Button Color Animation Only */
    @keyframes colorCycle {
        0%, 40% { color: #0057ff; }  /* Blue Text */
        50%, 90% { color: #2b2b2b; } /* Gray Text */
        100% { color: #0057ff; }     /* Back to Blue */
    }

    body::before {
        content: "";
        position: fixed;
        inset: -5%;
        width: 110%;
        height: 110%;
        z-index: -4;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 800'%3E%3Cpath fill='%23ffffff' fill-opacity='0.05' d='M0,256L48,261.3C96,267,192,277,288,293.3C384,309,480,331,576,314.7C672,299,768,245,864,245.3C960,245,1056,299,1152,298.7C1248,299,1344,245,1392,218.7L1440,192L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,416L48,421.3C96,427,192,437,288,421.3C384,405,480,363,576,362.7C672,363,768,405,864,432C960,459,1056,469,1152,448C1248,427,1344,373,1392,346.7L1440,320L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3Cpath fill='%23ffffff' fill-opacity='0.15' d='M0,576L48,586.7C96,597,192,619,288,602.7C384,587,480,533,576,512C672,491,768,501,864,528C960,555,1056,597,1152,597.3C1248,597,1344,555,1392,533.3L1440,512L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z'%3E%3C/path%3E%3C/svg%3E");
        background-size: cover;
        background-position: center bottom;
        opacity: 0.4;
        pointer-events: none;
        
        /* Interactive transform */
        transform: translate(var(--move-x), var(--move-y));
        transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* WAVE ANIMATIONS */
    .waves-container {
        position: fixed;
        left: -10%;
        width: 120%;
        height: 50vh;
        z-index: -1;
        pointer-events: none;
    }

    .waves-bottom { bottom: -100px; }
    .waves-top { top: -100px; transform: rotate(180deg); }

    .waves {
        position: relative;
        width: 100%;
        height: 100%;
        margin-bottom: -7px;
        min-height: 100px;
        transform: translate3d(var(--move-x), var(--move-y), 0);
        transition: transform 0.1s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .parallax > use {
        animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
    }
    .parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; fill: rgba(255, 255, 255, 0.05); }
    .parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; fill: rgba(255, 255, 255, 0.1); }
    .parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; fill: rgba(255, 255, 255, 0.15); }
    .parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; fill: rgba(255, 255, 255, 0.2); }

    @keyframes move-forever {
        0% { transform: translate3d(-90px, 0, 0); }
        100% { transform: translate3d(85px, 0, 0); }
    }

    main {
        z-index: 1;
        width: 100%;
        max-width: 420px;
        padding: 30px 25px;
        background: rgba(0, 0, 0, 0.55);
        backdrop-filter: blur(8px);
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        color: #fff;
    }

    h1 {
        font-family: 'Formula1 Display', sans-serif;
        font-size: 32px;
        margin-bottom: 24px;
        text-align: center;
    }

    label {
        display: block;
        margin: 10px 0 4px;
        font-size: 14px;
        color: #fff;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;           
        padding: 12px 14px;
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 8px;
        background: rgba(255,255,255,0.1);
        color: #fff;
        font-size: 15px;
        outline: none;
        transition: 0.2s;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #00f0ff;
        background: rgba(255,255,255,0.15);
    }

    button {
        width: 100%;
        padding: 12px;
        margin-top: 16px;
        border: none;
        border-radius: 50px;
        background: #fff;
        color: #0057ff;
        font-weight: 600;
        cursor: pointer;
        font-size: 16px;
        transition: 0.2s;
        /* Button Animation */
        animation: colorCycle 15s infinite ease-in-out;
    }

    button:hover {
        background: #eaeaea;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        margin-top: 12px;
        gap: 8px;
    }

    .checkbox-group input[type="checkbox"] {
        accent-color: #00f0ff;
        width: 18px;
        height: 18px;
    }

    .checkbox-group label {
        margin: 0;
        cursor: pointer;
        font-size: 15px;
        color: #fff;
    }

    .meta {
        margin-top: 16px;
        font-size: 14px;
        text-align: center;
    }

    .meta a {
        color: #fff; /* White text */
        text-decoration: none;
        transition: 0.2s;
    }

    .meta a:hover {
        text-decoration: underline;
        opacity: 0.8;
    }

    .error {
        background: rgba(255, 0, 0, 0.1);
        border-left: 4px solid #b91c1c;
        padding: 10px 12px;
        margin-bottom: 12px;
        font-size: 13px;
        color: #ffdddd;
        border-radius: 4px;
    }
</style>
</head>
<body>

<div class="bg-layer bg-blue"></div>
<div class="bg-layer bg-gray"></div>

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

<main>
    <h1>Sign in</h1>

    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required autocomplete="current-password">

        <div class="checkbox-group">
            <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember">Remember me</label>
        </div>

        <button type="submit">Log in</button>
    </form>

    <div class="meta">
        <div><a href="{{ route('welcome') }}">Back to Home</a></div>
        <div style="margin-top:6px;"><a href="{{ route('register') }}">Create an account</a></div>
    </div>
</main>

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