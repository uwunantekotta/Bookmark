<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management – Admin</title>
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

        .users-table {
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(8px);
            border-radius: 16px;
            overflow: hidden;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: rgba(0, 240, 255, 0.1);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid rgba(0, 240, 255, 0.3);
            font-size: 13px;
            text-transform: uppercase;
            color: #00f0ff;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        tr:hover {
            background: rgba(0, 240, 255, 0.05);
        }

        .role-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .role-badge.admin {
            background: rgba(255, 68, 68, 0.3);
            color: #ff4444;
        }

        .role-badge.contributor {
            background: rgba(255, 170, 0, 0.3);
            color: #ffaa00;
        }

        .role-badge.viewer {
            background: rgba(68, 221, 68, 0.3);
            color: #44dd44;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-edit {
            background: #00f0ff;
            color: #000;
            font-weight: 600;
        }

        .btn-edit:hover {
            background: #00d4e8;
        }

        .btn-delete {
            background: #ff4444;
            color: white;
            font-weight: 600;
        }

        .btn-delete:hover {
            background: #cc0000;
        }

        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            background: rgba(0, 0, 0, 0.55);
            border: 1px solid rgba(0, 240, 255, 0.3);
            border-radius: 6px;
            color: #00f0ff;
            text-decoration: none;
            transition: 0.2s;
        }

        .pagination a:hover {
            background: rgba(0, 240, 255, 0.2);
        }

        .pagination .active {
            background: #00f0ff;
            color: #000;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>User Management</h1>
            <a href="{{ route('admin.dashboard') }}" class="back-btn">← Back to Dashboard</a>
        </header>

        <div class="users-table">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                            <tr>
                                <td>
                                    {{ $user->name }}
                                    @if($user->banned)
                                        <div style="font-size:12px; color:#ffcccc;">(Banned)</div>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="role-badge {{ $user->role }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-edit">Edit</a>
                                        @if(auth()->user()->id !== $user->id)
                                            @if($user->banned)
                                                <form method="POST" action="{{ route('admin.users.unban', $user->id) }}" style="display:inline">
                                                    @csrf
                                                    <button type="submit" class="btn-edit">Unban</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.users.ban', $user->id) }}" style="display:inline" onsubmit="return confirm('Ban this user?');">
                                                    @csrf
                                                    <input type="hidden" name="banned_reason" value="Banned by admin">
                                                    <button type="submit" class="btn-delete">Ban</button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display: inline;" onsubmit="return confirm('Delete this user? This is permanent.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    {{ $user->email }}</td>
                                <td>
                                    <span class="role-badge {{ $user->role }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight:700;">⭐ {{ number_format($user->rating_avg ?? 0, 1) }}</div>
                                    <div style="font-size:12px; color:#aaa;">{{ $user->reviews_count ?? 0 }} reviews</div>
                                </td>
            </table>
        </div>

        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>
</body>
</html>
