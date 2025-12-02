<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Banned Users – Admin</title>
    <link href="https://fonts.cdnfonts.com/css/formula1-display" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        :root { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; color: #fff; }
        body { margin:0; min-height:100vh; background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%); padding:20px; }
        .container { max-width:1000px; margin:0 auto; }
        header { background: rgba(0,0,0,0.55); backdrop-filter: blur(8px); padding:20px 30px; border-radius:16px; margin-bottom:30px; display:flex; justify-content:space-between; align-items:center; }
        h1 { font-family:'Formula1 Display', sans-serif; font-size:28px; margin:0; }
        .back-btn { background:#00f0ff; color:#000; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600; }
        .users-table { background: rgba(0,0,0,0.55); backdrop-filter: blur(8px); border-radius:16px; overflow:hidden; width:100%; }
        table { width:100%; border-collapse:collapse; }
        th { background: rgba(0,240,255,0.1); padding:12px; text-align:left; color:#00f0ff; font-weight:600; }
        td { padding:12px; border-bottom:1px solid rgba(255,255,255,0.08); }
        .btn-unban { background:#44dd44; color:#000; padding:6px 10px; border-radius:6px; border:none; font-weight:600; }
        .btn-delete { background:#ff4444; color:#fff; padding:6px 10px; border-radius:6px; border:none; font-weight:600; }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>Banned Users</h1>
        <a href="{{ route('admin.dashboard') }}" class="back-btn">← Back to Dashboard</a>
    </header>

    <div class="users-table">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Reason</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->banned_reason ?? '-' }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.users.unban', $user->id) }}" style="display:inline">
                                @csrf
                                <button type="submit" class="btn-unban">Unban</button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display:inline" onsubmit="return confirm('Delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; color:#aaa; padding:20px;">No banned users</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px">{{ $users->links() }}</div>
</div>
</body>
</html>
