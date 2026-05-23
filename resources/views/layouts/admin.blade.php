<?php
use Illuminate\Support\Facades\Auth;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Lost & Found Management System</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/plugins.min.css">
    <link rel="stylesheet" href="/assets/css/kaiadmin.min.css">
    <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"],
                urls: ["/assets/css/fonts.min.css"],
            },
            active: function () { sessionStorage.fonts = true; },
        });
    </script>
    <style>
        .admin-sidebar {
            background: #1b4332 !important;
            min-height: 100vh;
            width: 220px;
            position: fixed;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }
        .admin-sidebar .logo-area {
            padding: 1.5rem 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .admin-sidebar .logo-area h6 {
            color: white;
            font-size: 11px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            opacity: 0.6;
            margin: 0;
        }
        .admin-sidebar .logo-area h5 {
            color: white;
            font-weight: 700;
            font-size: 14px;
            margin: 4px 0 0;
        }
        .admin-nav { padding: 1rem 0; flex: 1; }
        .admin-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 1.2rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            border-radius: 0;
        }
        .admin-nav a:hover, .admin-nav a.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .admin-nav a i { width: 18px; font-size: 14px; }
        .admin-nav .nav-section {
            padding: 1rem 1.2rem 0.3rem;
            font-size: 10px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
        }
        .admin-nav .badge-dot {
            background: #e74c3c;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: auto;
        }
        .admin-main {
            margin-left: 220px;
            min-height: 100vh;
            background: #f8f9fa;
        }
        .admin-topbar {
            background: white;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .admin-topbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
        }
        .admin-content { padding: 1.5rem; }
        .admin-footer {
            text-align: center;
            padding: 1rem;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #e0e0e0;
            background: white;
        }
    </style>
</head>
<body>

<div class="admin-sidebar">
    {{-- Logo --}}
    <div class="logo-area">
        <div class="d-flex align-items-center gap-2">
            <svg width="32" height="32" viewBox="0 0 38 38" fill="none">
                <circle cx="15" cy="15" r="11" fill="#1b4332" stroke="#4f8ef7" stroke-width="2.2"/>
                <path d="M11.5 15 C11.5 12 15 10.5 15 10.5 C15 10.5 18.5 12 18.5 15 C18.5 17.5 15 19.5 15 19.5 C15 19.5 11.5 17.5 11.5 15Z" fill="#f7617a"/>
                <line x1="23" y1="23" x2="31" y2="31" stroke="#4f8ef7" stroke-width="2.8" stroke-linecap="round"/>
                <circle cx="31" cy="31" r="2.5" fill="#4f8ef7"/>
            </svg>
            <div>
                <h5 class="mb-0" style="color:white; font-size:13px;">SNSU Admin</h5>
                <h6 class="mb-0">Control Center</h6>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <div class="admin-nav">
        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <a href="{{ route('admin.items') }}"
           class="{{ request()->routeIs('admin.items') ? 'active' : '' }}">
            <i class="fas fa-boxes"></i> Manage Items
        </a>

        <a href="{{ route('admin.users') }}"
           class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Manage Users
        </a>

        <a href="{{ route('admin.claims') }}"
           class="{{ request()->routeIs('admin.claims') ? 'active' : '' }}">
            <i class="fas fa-hand-holding"></i> Claims
            @php $pendingClaims = \App\Models\Claim::where('status','Pending')->count(); @endphp
            @if($pendingClaims > 0)
                <span class="badge-dot">{{ $pendingClaims }}</span>
            @endif
        </a>

        <a href="{{ route('admin.analytics') }}"
           class="{{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Analytics
        </a>
        
        <a href="{{ route('admin.reports') }}"
           class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> Reports
        </a>

        <a href="{{ route('admin.activity') }}"
           class="{{ request()->routeIs('admin.activity') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Activity Logs
        </a>
    </div>

    {{-- Logout --}}
    <div style="padding:1rem 1.2rem; border-top:1px solid rgba(255,255,255,0.1);">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                    style="background:rgba(255,255,255,0.1); border:none; color:rgba(255,255,255,0.8);
                           width:100%; padding:8px; border-radius:8px; font-size:13px; cursor:pointer;">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="admin-main">
    {{-- Topbar --}}
    <div class="admin-topbar">
        <div style="font-size:13px; color:#888;">
            <i class="fas fa-calendar me-1"></i>
            {{ now()->format('F d, Y') }}
        </div>
        <div class="user-info">
            <div style="width:32px; height:32px; border-radius:50%; background:#2d6a4f;
                        display:flex; align-items:center; justify-content:center; color:white; font-size:12px; font-weight:600;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span style="font-weight:600; color:#333;">{{ Auth::user()->name }}</span>
            <span class="badge" style="background:#e8f5ee; color:#2d6a4f; font-size:10px; padding:3px 8px; border-radius:10px;">
                Admin
            </span>
        </div>
    </div>

    {{-- Content --}}
    <div class="admin-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <div class="admin-footer">
        2024, SNSU Lost & Found Management System — Admin Panel
    </div>
</div>

<script src="/assets/js/core/jquery-3.7.1.min.js"></script>
<script src="/assets/js/core/bootstrap.min.js"></script>
</body>
</html>