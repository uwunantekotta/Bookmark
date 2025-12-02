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
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%);
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
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
</body>
</html>
