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
    }

    body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #0a4bff 0%, #0080ff 60%, #00a4ff 100%);
        overflow-x: hidden;
        position: relative;
    }

    body::before {
        content: "";
        position: fixed;
        inset: 0;
        background:
        background-size: cover;
        opacity: 0.25;
        pointer-events: none;
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
        color: #00f0ff;
        text-decoration: none;
        transition: 0.2s;
    }

    .meta a:hover {
        text-decoration: underline;
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

</body>
</html>
