<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameCache - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --purple: #7c6af7;
            --purple-light: #a78bfa;
            --purple-dim: rgba(124,106,247,.15);
            --sidebar-bg: #0e0e20;
            --page-bg: #080818;
            --card-bg: #11112a;
            --border: rgba(255,255,255,.07);
        }
        body { background: var(--page-bg); min-height: 100vh; }

        /* ── Sidebar ── */
        .sidebar {
            width: 260px; min-height: 100vh;
            position: fixed; top: 0; left: 0;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            z-index: 200;
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 12px;
            padding: 1.25rem 1.25rem 1rem;
            border-bottom: 1px solid var(--border);
            text-decoration: none;
        }
        .brand-icon {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, #7c6af7 0%, #a855f7 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.15rem; color: #fff; flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(124,106,247,.4);
        }
        .brand-text { font-size: 1.15rem; font-weight: 700; color: #fff; line-height: 1; }
        .brand-text span { color: var(--purple-light); }
        .brand-sub { font-size: .65rem; color: rgba(255,255,255,.3); letter-spacing: .05em; }

        .sidebar-section {
            font-size: .65rem; font-weight: 700;
            letter-spacing: .12em; text-transform: uppercase;
            color: rgba(255,255,255,.2);
            padding: 1rem 1.25rem .3rem;
        }
        .sidebar .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: .6rem 1rem; margin: 1px .75rem;
            border-radius: 10px; font-size: .875rem;
            color: rgba(255,255,255,.45);
            transition: all .15s ease;
        }
        .sidebar .nav-link i { font-size: 1rem; width: 20px; text-align: center; flex-shrink: 0; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,.06); color: rgba(255,255,255,.85); }
        .sidebar .nav-link.active { background: var(--purple-dim); color: var(--purple-light); font-weight: 600; }
        .sidebar .nav-link.active i { color: var(--purple); }

        .admin-badge {
            margin-left: auto;
            font-size: .6rem; font-weight: 700;
            background: rgba(124,106,247,.25);
            color: var(--purple-light);
            padding: 2px 7px; border-radius: 20px;
            letter-spacing: .03em;
        }

        .sidebar-footer { margin-top: auto; padding: .75rem; border-top: 1px solid var(--border); }
        .user-pill {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,.04);
            border: 1px solid var(--border);
            border-radius: 12px; padding: .65rem .85rem;
            margin-bottom: .6rem;
        }
        .user-pill-avatar {
            width: 36px; height: 36px; min-width: 36px; border-radius: 50%;
            background: linear-gradient(135deg, #7c6af7, #a855f7);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .9rem; color: #fff;
            border: 2px solid rgba(124,106,247,.4);
        }
        .user-pill-name { font-size: .82rem; font-weight: 600; color: #fff; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 130px; }
        .user-pill-role { font-size: .68rem; color: rgba(255,255,255,.3); }
        .user-pill-role.is-admin { color: var(--purple-light); }

        /* ── Main ── */
        .main-content { margin-left: 260px; padding: 2rem; min-height: 100vh; }

        /* ── Cards ── */
        .card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 14px; }
        .card-header { background: rgba(255,255,255,.03); border-bottom: 1px solid var(--border); padding: .9rem 1.25rem; }

        /* ── Stat card ── */
        .stat-card { border-radius: 14px; padding: 1.25rem 1.5rem; border: 1px solid var(--border); background: var(--card-bg); position: relative; overflow: hidden; }
        .stat-card::before { content:''; position:absolute; top:-30px; right:-30px; width:100px; height:100px; border-radius:50%; opacity:.07; }
        .stat-card.purple::before { background: #7c6af7; }
        .stat-card.green::before  { background: #22c55e; }
        .stat-card.blue::before   { background: #3b82f6; }
        .stat-card.pink::before   { background: #a855f7; }
        .stat-card .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; margin-bottom: .85rem;
        }
        .stat-card .stat-label { font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; color: rgba(255,255,255,.35); margin-bottom: .3rem; }
        .stat-card .stat-value { font-size: 2rem; font-weight: 700; line-height: 1; margin-bottom: .3rem; }
        .stat-card .stat-sub { font-size: .78rem; color: rgba(255,255,255,.3); }

        /* ── Table ── */
        .table { color: rgba(255,255,255,.75); }
        .table thead th { background: rgba(0,0,0,.2); border-color: var(--border); color: rgba(255,255,255,.3); font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; padding: .85rem 1.1rem; }
        .table td { border-color: rgba(255,255,255,.04); padding: .9rem 1.1rem; vertical-align: middle; }
        .table tbody tr:hover { background: rgba(124,106,247,.05); }

        /* ── Forms ── */
        .form-control, .form-select {
            background: rgba(255,255,255,.05); border-color: rgba(255,255,255,.1);
            color: #fff; border-radius: 10px; padding: .6rem .9rem;
            transition: all .2s;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,.07);
            border-color: var(--purple); color: #fff;
            box-shadow: 0 0 0 3px rgba(124,106,247,.2);
        }
        .form-control::placeholder { color: rgba(255,255,255,.2); }
        .form-select option { background: #1a1a3a; }
        .form-label { font-size: .82rem; font-weight: 500; color: rgba(255,255,255,.5); margin-bottom: .4rem; }
        .input-group-text { background: rgba(255,255,255,.04); border-color: rgba(255,255,255,.1); color: rgba(255,255,255,.3); }
        .invalid-feedback { font-size: .78rem; }
        .is-invalid { border-color: #f54a4a !important; }

        /* ── Buttons ── */
        .btn-primary { background: var(--purple); border-color: var(--purple); border-radius: 10px; font-weight: 500; }
        .btn-primary:hover { background: #6a58e5; border-color: #6a58e5; box-shadow: 0 4px 15px rgba(124,106,247,.35); }
        .btn-outline-secondary { border-color: rgba(255,255,255,.1); color: rgba(255,255,255,.4); border-radius: 10px; }
        .btn-outline-secondary:hover { background: rgba(255,255,255,.06); color: rgba(255,255,255,.8); border-color: rgba(255,255,255,.15); }

        /* ── Modals ── */
        .modal-content { background: #13132e; border: 1px solid rgba(255,255,255,.1); border-radius: 18px; }
        .modal-header { border-bottom: 1px solid rgba(255,255,255,.07); padding: 1.35rem 1.5rem; }
        .modal-body { padding: 1.5rem; }
        .modal-footer { border-top: 1px solid rgba(255,255,255,.07); padding: 1rem 1.5rem; }
        .modal-title { font-weight: 700; font-size: 1rem; }
        .modal-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }

        /* ── Badges ── */
        .badge-owned     { background: rgba(34,197,94,.15);  color: #4ade80; padding: 5px 12px; border-radius: 20px; font-size: .78rem; font-weight: 500; }
        .badge-playing   { background: rgba(59,130,246,.15); color: #60a5fa; padding: 5px 12px; border-radius: 20px; font-size: .78rem; font-weight: 500; }
        .badge-completed { background: rgba(168,85,247,.15); color: #c084fc; padding: 5px 12px; border-radius: 20px; font-size: .78rem; font-weight: 500; }
        .badge-wishlist  { background: rgba(245,158,11,.15); color: #fbbf24; padding: 5px 12px; border-radius: 20px; font-size: .78rem; font-weight: 500; }

        /* ── Pagination ── */
        .page-link { background: var(--card-bg); border-color: var(--border); border-radius: 8px !important; margin: 0 2px; font-size: .85rem; color: rgba(255,255,255,.4); }
        .page-link:hover { background: rgba(255,255,255,.07); color: var(--purple-light); border-color: var(--border); }
        .page-item.active .page-link { background: var(--purple); border-color: var(--purple); color: #fff; }
        .page-item.disabled .page-link { background: rgba(0,0,0,.2); color: rgba(255,255,255,.15); }

        /* ── Toast ── */
        .toast-container { position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999; }
        .toast { border-radius: 14px; min-width: 300px; border: none; backdrop-filter: blur(10px); }
        .toast-success { background: rgba(15,40,25,.95); border-left: 4px solid #22c55e !important; }
        .toast-error   { background: rgba(40,10,10,.95); border-left: 4px solid #ef4444 !important; }

        /* ── Misc ── */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 10px; }
        a { color: var(--purple-light); }
        a:hover { color: #c4b5fd; }
    </style>
</head>
<body>

@auth
<div class="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-controller"></i></div>
        <div>
            <div class="brand-text">Game<span>Cache</span></div>
            <div class="brand-sub">GAME COLLECTION</div>
        </div>
    </a>

    <nav class="nav flex-column pt-1 flex-grow-1 overflow-auto">
        <div class="sidebar-section">Main</div>
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('games.index') }}"
           class="nav-link {{ request()->routeIs('games*') ? 'active' : '' }}">
            <i class="bi bi-joystick"></i>
            <span>My Collection</span>
        </a>

        @if(auth()->user()->is_admin)
        <div class="sidebar-section">Admin</div>
        <a href="{{ route('users.index') }}"
           class="nav-link {{ request()->routeIs('users*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>Users</span>
            <span class="admin-badge">ADMIN</span>
        </a>
        @endif

        <div class="sidebar-section">Account</div>
        <a href="{{ route('profile.edit') }}"
           class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            <span>My Profile</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-pill">
            @if(auth()->user()->avatar)
                <img src="{{ asset('avatars/' . auth()->user()->avatar) }}"
                     class="user-pill-avatar" style="object-fit:cover">
            @else
                <div class="user-pill-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
            <div class="overflow-hidden flex-grow-1">
                <div class="user-pill-name">{{ auth()->user()->name }}</div>
                <div class="user-pill-role {{ auth()->user()->is_admin ? 'is-admin' : '' }}">
                    @if(auth()->user()->is_admin)
                        <i class="bi bi-shield-check me-1"></i>Administrator
                    @else
                        <i class="bi bi-person me-1"></i>Member
                    @endif
                </div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-secondary btn-sm w-100">
                <i class="bi bi-box-arrow-right me-2"></i>Sign Out
            </button>
        </form>
    </div>
</div>
@endauth

<!-- Main Content -->
<div class="{{ auth()->check() ? 'main-content' : '' }}">
    @yield('content')
</div>

<!-- Toast Notifications -->
<div class="toast-container">
    @if(session('success'))
    <div class="toast toast-success show mb-2" role="alert">
        <div class="d-flex align-items-center p-3 gap-2">
            <div style="width:32px;height:32px;background:rgba(34,197,94,.2);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <i class="bi bi-check-lg text-success"></i>
            </div>
            <div class="flex-grow-1">
                <div style="font-size:.75rem;color:rgba(255,255,255,.4);font-weight:600;text-transform:uppercase;letter-spacing:.05em">Success</div>
                <div style="font-size:.875rem;color:rgba(255,255,255,.85)">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="toast toast-error show mb-2" role="alert">
        <div class="d-flex align-items-center p-3 gap-2">
            <div style="width:32px;height:32px;background:rgba(239,68,68,.2);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <i class="bi bi-exclamation-lg text-danger"></i>
            </div>
            <div class="flex-grow-1">
                <div style="font-size:.75rem;color:rgba(255,255,255,.4);font-weight:600;text-transform:uppercase;letter-spacing:.05em">Error</div>
                <div style="font-size:.875rem;color:rgba(255,255,255,.85)">{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endif
</div>

<!-- Scripts BEFORE closing body tag -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.querySelectorAll('.toast').forEach(t => {
        setTimeout(() => bootstrap.Toast.getOrCreateInstance(t).hide(), 4000);
    });
</script>
@yield('scripts')
</body>
</html>