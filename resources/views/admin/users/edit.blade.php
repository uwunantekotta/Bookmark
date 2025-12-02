<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User – Admin</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(8px);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        h1 {
            font-family: 'Formula1 Display', sans-serif;
            font-size: 28px;
            margin: 0 0 24px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #00f0ff;
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 15px;
            outline: none;
            transition: 0.2s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #00f0ff;
            background: rgba(255, 255, 255, 0.15);
        }

        select option {
            background: #1a1a1a;
            color: #fff;
        }

        .readonly {
            background: rgba(255, 255, 255, 0.05);
            cursor: not-allowed;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 24px;
        }

        button, .back-btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        button[type="submit"] {
            background: #44dd44;
            color: #000;
        }

        button[type="submit"]:hover {
            background: #2fb82f;
        }

        .back-btn {
            background: rgba(0, 240, 255, 0.2);
            color: #00f0ff;
            border: 1px solid rgba(0, 240, 255, 0.5);
        }

        .back-btn:hover {
            background: rgba(0, 240, 255, 0.3);
        }

        .error-message {
            background: rgba(255, 0, 0, 0.1);
            border-left: 4px solid #b91c1c;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-size: 13px;
            color: #ffdddd;
            border-radius: 4px;
        }

        .success-message {
            background: rgba(68, 221, 68, 0.1);
            border-left: 4px solid #44dd44;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-size: 13px;
            color: #aaffaa;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>

        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="error-message">{{ $error }}</div>
            @endforeach
        @endif

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.users.updateRole', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ $user->email }}" readonly class="readonly">
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role">
                    <option value="viewer" {{ $user->role === 'viewer' ? 'selected' : '' }}>Viewer (View only)</option>
                    <option value="contributor" {{ $user->role === 'contributor' ? 'selected' : '' }}>Contributor (Upload songs)</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin (Full access)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">New password (leave blank to keep current)</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm new password</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>

            <div class="form-group">
                @if($user->banned)
                    <p style="color:#ffcccc">This user is currently banned. Reason: {{ $user->banned_reason }}</p>
                    <form method="POST" action="{{ route('admin.users.unban', $user->id) }}">
                        @csrf
                        <button type="submit" class="back-btn" style="margin-top:6px;">Unban user</button>
                    </form>
                @endif
            </div>

            <div class="button-group">
                <button type="submit">Update Role</button>
                <a href="{{ route('admin.users.index') }}" class="back-btn">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
