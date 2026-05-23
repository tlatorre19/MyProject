<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Lost & Found Management System</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 40%, #0f3460 70%, #1a1a2e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-wrapper {
            display: flex;
            width: 900px;
            max-width: 95vw;
            min-height: 520px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        }

        .welcome-side {
            flex: 1;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            text-align: center;
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        .logo-circle {
            width: 90px;
            height: 90px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .welcome-side h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .welcome-side p {
            color: rgba(255,255,255,0.65);
            font-size: 0.9rem;
            line-height: 1.6;
            max-width: 220px;
        }

        .admin-tag {
            margin-top: 2rem;
            font-size: 11px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
        }

        .admin-badge {
            display: inline-block;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            font-size: 11px;
            padding: 4px 14px;
            border-radius: 20px;
            margin-top: 1rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .form-side {
            flex: 1;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 2.5rem;
        }

        .form-side h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f3460;
            margin-bottom: 0.3rem;
        }

        .form-side p.subtitle {
            color: #888;
            font-size: 0.85rem;
            margin-bottom: 1.8rem;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #555;
            margin-bottom: 5px;
        }

        .form-control {
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #0f3460;
            box-shadow: 0 0 0 3px rgba(15,52,96,0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, #0f3460, #16213e);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 11px;
            font-size: 15px;
            font-weight: 600;
            width: 100%;
            margin-top: 0.5rem;
            transition: opacity 0.2s;
        }

        .btn-login:hover { opacity: 0.9; color: white; }

        .back-link {
            text-align: center;
            margin-top: 1.2rem;
            font-size: 13px;
            color: #888;
        }

        .back-link a {
            color: #0f3460;
            font-weight: 600;
            text-decoration: none;
        }

        .back-link a:hover { text-decoration: underline; }

        @media (max-width: 650px) {
            .welcome-side { display: none; }
            .login-wrapper { width: 95vw; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    {{-- Left: Welcome Side --}}
    <div class="welcome-side">
        <div class="logo-circle">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="20" cy="20" r="13" fill="none" stroke="white" stroke-width="3"/>
                <path d="M15 20 C15 16 20 13.5 20 13.5 C20 13.5 25 16 25 20 C25 23.5 20 26.5 20 26.5 C20 26.5 15 23.5 15 20Z"
                      fill="#f7617a" opacity="0.9"/>
                <line x1="29" y1="29" x2="39" y2="39" stroke="white" stroke-width="3.5" stroke-linecap="round"/>
                <circle cx="39" cy="39" r="3" fill="white"/>
            </svg>
        </div>

        <h1>Admin<br>Control Center</h1>
        <p>Manage and oversee all lost and found reports at <strong style="color:white;">SNSU</strong>.</p>
        <div class="admin-badge">🔒 Admin Access Only</div>
        <div class="admin-tag">SNSU Recovery System</div>
    </div>

    {{-- Right: Login Form --}}
    <div class="form-side">
        <h2>Admin Login</h2>
        <p class="subtitle">Sign in with your admin credentials</p>

        @if($errors->any())
            <div class="alert alert-danger mb-3" style="font-size:13px; border-radius:10px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="Enter admin email" required autofocus>
                @error('email')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Enter admin password" required>
                @error('password')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <button type="submit" class="btn btn-login">
                Login as Admin
            </button>
        </form>

        <div class="back-link">
            Not an admin? <a href="{{ route('login') }}">Go to Student/Instructor Login</a>
        </div>
    </div>

</div>

</body>
</html>