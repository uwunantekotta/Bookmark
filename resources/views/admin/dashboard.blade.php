<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard – Audiobook</title>
    <link href="https://fonts.cdnfonts.com/css/formula1-display" rel="stylesheet">
    <style>
        * {
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
            /* Removed static background to use animated layers */
            overflow-x: hidden;
            position: relative;
        }

        /* --- BACKGROUND LAYERS --- */
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

        /* --- WAVE ANIMATIONS --- */
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

        /* --- DASHBOARD STYLES --- */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            /* Ensure content sits above waves */
            z-index: 1;
            position: relative;
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

        .logout-btn {
            background: #ff4444;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #cc0000;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(8px);
            padding: 25px;
            border-radius: 16px;
            border-left: 4px solid #00f0ff;
        }

        .dashboard-card.pending {
            border-left-color: #ffaa00;
        }

        .dashboard-card.approved {
            border-left-color: #44dd44;
        }

        .dashboard-card.rejected {
            border-left-color: #ff4444;
        }

        .card-title {
            font-size: 14px;
            color: #aaa;
            margin: 0 0 10px;
            text-transform: uppercase;
        }

        .card-value {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
        }

        .admin-menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .menu-card {
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(8px);
            padding: 30px;
            border-radius: 16px;
            text-align: center;
            transition: 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 240, 255, 0.3);
        }

        .menu-card h2 {
            font-size: 20px;
            margin: 0 0 10px;
        }

        .menu-card p {
            color: #aaa;
            font-size: 14px;
            margin: 0 0 15px;
        }

        .menu-card a {
            display: inline-block;
            background: #00f0ff;
            color: #000;
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s;
        }

        .menu-card a:hover {
            background: #00d4e8;
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

    <div class="container">
        <header>
            <h1>Admin Dashboard</h1>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </header>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <p class="card-title">Total Users</p>
                <p class="card-value">{{ $totalUsers }}</p>
            </div>
            <div class="dashboard-card">
                <p class="card-title">Total Music</p>
                <p class="card-value">{{ $totalMusic }}</p>
            </div>
            <div class="dashboard-card pending">
                <p class="card-title">Pending Songs</p>
                <p class="card-value">{{ $pendingMusic }}</p>
            </div>
            <div class="dashboard-card approved">
                <p class="card-title">Approved Songs</p>
                <p class="card-value">{{ $approvedMusic }}</p>
            </div>
            <div class="dashboard-card rejected">
                <p class="card-title">Rejected Songs</p>
                <p class="card-value">{{ $rejectedMusic }}</p>
            </div>
        </div>

        <div class="admin-menu">
            <div class="menu-card">
                <h2>👥 Manage Users</h2>
                <p>View, edit user roles, and manage user accounts</p>
                <a href="{{ route('admin.users.index') }}">Manage Users</a>
            </div>
            <div class="menu-card">
                <h2>🚫 Banned Users</h2>
                <p>View and unban or delete banned accounts</p>
                <a href="{{ route('admin.users.banned') }}">View Banned</a>
            </div>
            <div class="menu-card">
                <h2>🎵 Approve Songs</h2>
                <p>Review and approve or reject song uploads</p>
                <a href="{{ route('admin.music.index') }}">Approve Songs</a>
            </div>
            <div class="menu-card">
                <h2>❌ Rejected Songs</h2>
                <p>View all rejected songs and rejection reasons</p>
                <a href="{{ route('admin.music.rejected') }}">View Rejected</a>
            </div>
        </div>
    </div>

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