<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Audiobook – Register</title>

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

    input[type="text"],
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

    /* Role select styling */
    .role-select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 8px;
        background: rgba(255,255,255,0.12);
        background-color: #ffffff;
        color: #000 !important;
        font-size: 15px;
        outline: none;
        transition: 0.2s;
    }

    /* Try to ensure option readability in dropdowns */
    .role-select option {
        background: #fff;
        color: #000;
    }

    input[type="text"]:focus,
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

    .password-strength-container {
        margin-top: 8px;
        margin-bottom: 12px;
    }

    .strength-bar {
        width: 100%;
        height: 6px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .strength-bar-fill {
        height: 100%;
        width: 0%;
        transition: width 0.3s ease, background-color 0.3s ease;
        border-radius: 3px;
    }

    .strength-bar-fill.weak {
        background: #ff4444;
        width: 33%;
    }

    .strength-bar-fill.fair {
        background: #ffaa00;
        width: 66%;
    }

    .strength-bar-fill.strong {
        background: #44dd44;
        width: 100%;
    }

    .strength-requirements {
        font-size: 12px;
        color: #ccc;
    }

    .requirement {
        display: flex;
        align-items: center;
        margin: 4px 0;
        gap: 6px;
    }

    .requirement-icon {
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: bold;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    .requirement.met .requirement-icon {
        background: #44dd44;
        color: #000;
    }

    .requirement-text {
        flex: 1;
    }

    .strength-label {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #aaa;
    }

    .strength-label.weak {
        color: #ff4444;
    }

    .strength-label.fair {
        color: #ffaa00;
    }

    .strength-label.strong {
        color: #44dd44;
    }
</style>
</head>
<body>

<main>
    <h1>Create an account</h1>

    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ url('/register') }}">
        @csrf
        <label for="name">Full name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name">

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>

        <label for="role">Role</label>
        <select id="role" name="role" class="role-select">
            <option value="viewer" {{ old('role') === 'viewer' ? 'selected' : '' }}>Viewer (view only)</option>
            <option value="contributor" {{ old('role') === 'contributor' ? 'selected' : '' }}>Contributor (upload songs)</option>
            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (manage users & approvals)</option>
        </select>
        <div id="roleDisplay" style="margin-top:6px;">
            <small style="color:#fff">Selected role: <span id="roleChoice">{{ old('role') ? ucfirst(old('role')) : 'Viewer' }}</span></small>
        </div>

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required onInput="checkPasswordStrength()">

        <div class="password-strength-container">
            <div class="strength-bar">
                <div id="strengthBarFill" class="strength-bar-fill"></div>
            </div>
            <div class="strength-label" id="strengthLabel"></div>
            <div class="strength-requirements">
                <div class="requirement" id="req-length">
                    <div class="requirement-icon">✓</div>
                    <div class="requirement-text">8-64 characters</div>
                </div>
                <div class="requirement" id="req-uppercase">
                    <div class="requirement-icon">✓</div>
                    <div class="requirement-text">At least 1 capital letter (A-Z)</div>
                </div>
                <div class="requirement" id="req-number">
                    <div class="requirement-icon">✓</div>
                    <div class="requirement-text">At least 1 number (0-9)</div>
                </div>
                <div class="requirement" id="req-symbol">
                    <div class="requirement-icon">✓</div>
                    <div class="requirement-text">At least 1 symbol (!@#$%^&*)</div>
                </div>
            </div>
        </div>

        <label for="password_confirmation">Confirm password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>

        <button type="submit">Create account</button>
    </form>

    <div class="meta">
        <div><a href="{{ route('login') }}">Already have an account? Sign in</a></div>
    </div>
</main>

<script>
function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    
    // Check requirements
    const lengthMet = password.length >= 8 && password.length <= 64;
    const uppercaseMet = /[A-Z]/.test(password);
    const numberMet = /[0-9]/.test(password);
    const symbolMet = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
    
    // Update requirement elements
    updateRequirement('req-length', lengthMet);
    updateRequirement('req-uppercase', uppercaseMet);
    updateRequirement('req-number', numberMet);
    updateRequirement('req-symbol', symbolMet);
    
    // Calculate strength
    let metCount = [lengthMet, uppercaseMet, numberMet, symbolMet].filter(Boolean).length;
    let strength = 'none';
    
    if (password.length === 0) {
        strength = 'none';
    } else if (metCount <= 1) {
        strength = 'weak';
    } else if (metCount <= 2) {
        strength = 'fair';
    } else if (metCount === 3) {
        strength = 'fair';
    } else {
        strength = 'strong';
    }
    
    // Update bar and label
    const bar = document.getElementById('strengthBarFill');
    const label = document.getElementById('strengthLabel');
    
    bar.className = 'strength-bar-fill';
    label.className = 'strength-label';
    
    if (password.length === 0) {
        bar.className = 'strength-bar-fill';
        label.textContent = '';
    } else if (strength === 'weak') {
        bar.classList.add('weak');
        label.classList.add('weak');
        label.textContent = 'Weak password';
    } else if (strength === 'fair') {
        bar.classList.add('fair');
        label.classList.add('fair');
        label.textContent = 'Fair password';
    } else if (strength === 'strong') {
        bar.classList.add('strong');
        label.classList.add('strong');
        label.textContent = 'Strong password';
    }
}

function updateRequirement(elementId, isMet) {
    const element = document.getElementById(elementId);
    if (isMet) {
        element.classList.add('met');
    } else {
        element.classList.remove('met');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    checkPasswordStrength();
    // Update visible role label
    const roleSelect = document.getElementById('role');
    const roleChoice = document.getElementById('roleChoice');
    if (roleSelect && roleChoice) {
        roleChoice.textContent = roleSelect.options[roleSelect.selectedIndex].text;
        roleSelect.addEventListener('change', function() {
            roleChoice.textContent = this.options[this.selectedIndex].text;
        });
    }
});
</script>

</body>
</html>
