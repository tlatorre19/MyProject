<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Lost & Found Management System</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a3c2e 0%, #2d6a4f 40%, #40916c 70%, #1b4332 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            padding: 2rem 0;
        }
        .register-wrapper {
            display: flex;
            width: 900px;
            max-width: 95vw;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
        }
        .welcome-side {
            flex: 0 0 320px;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            text-align: center;
            border-right: 1px solid rgba(255,255,255,0.15);
        }
        .logo-circle {
            width: 90px; height: 90px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 2px solid rgba(255,255,255,0.3);
        }
        .welcome-side h1 { font-size: 1.5rem; font-weight: 700; color: white; margin-bottom: 0.5rem; line-height: 1.3; }
        .welcome-side p { color: rgba(255,255,255,0.75); font-size: 0.85rem; line-height: 1.6; max-width: 220px; }
        .system-tag { margin-top: 2rem; font-size: 11px; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.5); }
        .form-side {
            flex: 1; background: white;
            display: flex; flex-direction: column; justify-content: center;
            padding: 2.5rem; overflow-y: auto;
        }
        .form-side h2 { font-size: 1.4rem; font-weight: 700; color: #1b4332; margin-bottom: 0.3rem; }
        .form-side p.subtitle { color: #888; font-size: 0.85rem; margin-bottom: 1.5rem; }
        .form-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #555; margin-bottom: 5px; }
        .form-control, .form-select { border: 1.5px solid #e0e0e0; border-radius: 10px; padding: 10px 14px; font-size: 14px; transition: border-color 0.2s; }
        .form-control:focus, .form-select:focus { border-color: #2d6a4f; box-shadow: 0 0 0 3px rgba(45,106,79,0.1); }
        .role-card { flex: 1; padding: 12px; border: 2px solid #e0e0e0; border-radius: 10px; text-align: center; cursor: pointer; transition: all 0.2s; background: white; }
        .role-card:hover { border-color: #2d6a4f; background: #f0faf5; }
        .role-card.selected { border-color: #2d6a4f; background: #f0faf5; color: #2d6a4f; }
        .role-card i { font-size: 22px; margin-bottom: 4px; display: block; }
        .role-card p { font-size: 13px; font-weight: 600; margin: 0; }
        .btn-register { background: linear-gradient(135deg, #2d6a4f, #40916c); color: white; border: none; border-radius: 10px; padding: 11px; font-size: 15px; font-weight: 600; width: 100%; margin-top: 0.5rem; transition: opacity 0.2s; }
        .btn-register:hover { opacity: 0.9; color: white; }
        .login-link { text-align: center; margin-top: 1rem; font-size: 13px; color: #888; }
        .login-link a { color: #2d6a4f; font-weight: 600; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }
        .id-hint { font-size: 11px; color: #999; margin-top: 4px; }
        .id-hint.error { color: #dc3545; }
        @media (max-width: 650px) { .welcome-side { display: none; } .register-wrapper { width: 95vw; } }
    </style>
</head>
<body>

<div class="register-wrapper">

    <div class="welcome-side">
        <div class="logo-circle">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                <circle cx="20" cy="20" r="13" fill="none" stroke="white" stroke-width="3"/>
                <path d="M15 20 C15 16 20 13.5 20 13.5 C20 13.5 25 16 25 20 C25 23.5 20 26.5 20 26.5 C20 26.5 15 23.5 15 20Z" fill="#f7617a" opacity="0.9"/>
                <line x1="29" y1="29" x2="39" y2="39" stroke="white" stroke-width="3.5" stroke-linecap="round"/>
                <circle cx="39" cy="39" r="3" fill="white"/>
            </svg>
        </div>
        <h1>Lost & Found<br>Management System</h1>
        <p>The official lost and found system of <strong style="color:white;">Surigao del Norte State University</strong> helping students and staff recover missing belongings on campus.</p>
        <div class="system-tag">SNSU Recovery System</div>
    </div>

    <div class="form-side">
        <h2>Create Account</h2>
        <p class="subtitle">Join the SNSU Lost & Found community</p>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            {{-- Role Selector --}}
            <div class="mb-3">
                <label class="form-label">I Am A</label>
                <div class="d-flex gap-2">
                    <div class="role-card selected" id="student-card" onclick="selectRole('student')">
                        <i class="fas fa-user-graduate"></i>
                        <p>Student</p>
                    </div>
                    <div class="role-card" id="instructor-card" onclick="selectRole('instructor')">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <p>Instructor</p>
                    </div>
                </div>
                <input type="hidden" name="role" id="role" value="student">
                @if($errors->has('role'))
                    <span class="text-danger small"><strong>{{ $errors->first('role') }}</strong></span>
                @endif
            </div>

            {{-- Full Name --}}
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input id="name" type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') }}"
                    required autocomplete="name" autofocus
                    placeholder="Enter your full name">
                @error('name')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            {{-- Student ID --}}
            <div class="mb-3" id="student-id-field">
                <label class="form-label">Student ID</label>
                <input id="student_id" type="text"
                    class="form-control @error('student_id') is-invalid @enderror"
                    name="student_id"
                    value="{{ old('student_id') }}"
                    placeholder="e.g. 2024-00593"
                    maxlength="10"
                    inputmode="numeric">
                <div class="id-hint" id="student-id-hint">Format: YYYY-NNNNN (numbers only, e.g. 2024-00593)</div>
                @error('student_id')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            {{-- Instructor ID --}}
            <div class="mb-3" id="instructor-id-field" style="display:none;">
                <label class="form-label">Instructor ID</label>
                <input id="instructor_id" type="text"
                    class="form-control"
                    name="student_id"
                    value="{{ old('student_id') }}"
                    placeholder="e.g. INST-001">
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input id="email" type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}"
                    required autocomplete="email"
                    placeholder="Enter your email">
                @error('email')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password"
                    placeholder="Enter your password">
                @error('password')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input id="password-confirm" type="password"
                    class="form-control"
                    name="password_confirmation"
                    required autocomplete="new-password"
                    placeholder="Confirm your password">
            </div>

            <button type="submit" class="btn btn-register">
                Register Now
            </button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </div>
    </div>
</div>

<script>
    function selectRole(role) {
        document.getElementById('role').value = role;
        document.getElementById('student-card').classList.remove('selected');
        document.getElementById('instructor-card').classList.remove('selected');
        document.getElementById(role + '-card').classList.add('selected');

        if (role === 'student') {
            document.getElementById('student-id-field').style.display = 'block';
            document.getElementById('instructor-id-field').style.display = 'none';
            document.getElementById('instructor_id').value = '';
        } else {
            document.getElementById('student-id-field').style.display = 'none';
            document.getElementById('instructor-id-field').style.display = 'block';
            document.getElementById('student_id').value = '';
        }
    }

    // Auto-format Student ID as YYYY-NNNNN
    const studentIdInput = document.getElementById('student_id');
    const hint = document.getElementById('student-id-hint');

    studentIdInput.addEventListener('input', function (e) {
        let raw = this.value.replace(/\D/g, ''); // remove all non-digits
        if (raw.length > 9) raw = raw.substring(0, 9); // max 9 digits

        // auto insert dash after 4 digits
        if (raw.length > 4) {
            this.value = raw.substring(0, 4) + '-' + raw.substring(4);
        } else {
            this.value = raw;
        }

        // validate format
        const pattern = /^\d{4}-\d{5}$/;
        if (this.value.length === 0) {
            hint.textContent = 'Format: YYYY-NNNNN (numbers only, e.g. 2024-00593)';
            hint.classList.remove('error');
            this.classList.remove('is-invalid');
        } else if (pattern.test(this.value)) {
            hint.textContent = '✓ Valid Student ID format';
            hint.style.color = '#2d6a4f';
            hint.classList.remove('error');
            this.classList.remove('is-invalid');
        } else {
            hint.textContent = '✗ Invalid format. Must be YYYY-NNNNN (e.g. 2024-00593)';
            hint.classList.add('error');
            hint.style.color = '#dc3545';
        }
    });

    // Block letters and special characters on keypress
    studentIdInput.addEventListener('keypress', function(e) {
        if (!/[0-9]/.test(e.key)) {
            e.preventDefault();
        }
    });

    // Prevent paste of non-numeric characters
    studentIdInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData).getData('text');
        const nums = pasted.replace(/\D/g, '').substring(0, 9);
        if (nums.length > 4) {
            this.value = nums.substring(0, 4) + '-' + nums.substring(4);
        } else {
            this.value = nums;
        }
        this.dispatchEvent(new Event('input'));
    });

    window.onload = function() {
        selectRole('student');
    };
</script>

</body>
</html>