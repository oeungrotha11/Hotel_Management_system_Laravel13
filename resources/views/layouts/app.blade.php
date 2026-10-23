<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'StayEase | Hotel Management')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { brand: { 50:'#eef6ff', 100:'#dbeafe', 500:'#3977e8', 600:'#285fc7', 700:'#214b9b', 900:'#14213d' } }, boxShadow: { soft:'0 12px 35px rgba(15,23,42,.06)' } } } };
    </script>
    <style>
        :root{--ink:#172033;--muted:#64748b;--line:#e7ebf2;--paper:#f6f8fc;--navy:#14213d;--blue:#3977e8}
        *{box-sizing:border-box} body{margin:0;background:var(--paper);color:var(--ink);font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}
        a{transition:color .18s,background .18s,border-color .18s} .app-shell{min-height:100vh}
        .admin-sidebar{position:fixed;inset:0 auto 0 0;width:260px;background:#111c33;color:#cbd5e1;display:flex;flex-direction:column;padding:26px 18px;z-index:30}
        .brand-mark{width:40px;height:40px;display:grid;place-items:center;border-radius:13px;background:linear-gradient(135deg,#76a9ff,#3977e8);color:white;font-size:20px;box-shadow:0 8px 20px #3977e84d}
        .side-label{font-size:10px;letter-spacing:.16em;text-transform:uppercase;color:#7f8ca5;font-weight:800;padding:24px 12px 9px}
        .side-link{display:flex;align-items:center;gap:12px;padding:11px 13px;margin:3px 0;border-radius:11px;color:#aebbd0;font-size:13px;font-weight:650;text-decoration:none}
        .side-link:hover{background:#ffffff0d;color:white}.side-link.active{background:#2b5cb7;color:#fff;box-shadow:0 8px 18px #08152b66}
        .admin-main{margin-left:260px;min-width:0}.admin-topbar{height:76px;background:#fff;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 34px;gap:16px}
        .page-wrap{max-width:1600px;margin:0 auto;padding:30px 34px 44px}.top-link{font-size:13px;font-weight:650;color:#526079;text-decoration:none;padding:10px 12px;border-radius:9px}.top-link:hover,.top-link.active{background:#eef4ff;color:#285fc7}
        .container{max-width:1500px;margin:0 auto;padding:0}.card{background:#fff;border:1px solid var(--line);border-radius:18px;padding:22px;margin-bottom:18px;box-shadow:0 5px 20px #0f172a05}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;border:1px solid transparent;border-radius:10px;padding:10px 15px;background:var(--blue);color:white;text-decoration:none;cursor:pointer;font-size:13px;font-weight:700;white-space:nowrap}.btn:hover{background:#285fc7;color:white}.btn.gray{background:white;border-color:#dce3ee;color:#475569}.btn.gray:hover{background:#f1f5f9}.btn.red{background:#fff1f2;color:#be123c;border-color:#ffe4e6}.btn.red:hover{background:#ffe4e6}.btn.green{background:#0f9f75;color:white}.btn.green:hover{background:#087f5b}
        input,select,textarea{width:100%;padding:11px 13px;border:1px solid #dbe2ec;border-radius:10px;margin-top:7px;background:#fff;color:#172033;font:inherit;font-size:14px;outline:none}input:focus,select:focus,textarea:focus{border-color:#7aa6f8;box-shadow:0 0 0 3px #3977e81a}
        label{font-weight:650;font-size:13px;display:block;margin-bottom:15px;color:#344158}table{width:100%;border-collapse:collapse;background:white}th,td{padding:15px 14px;border-bottom:1px solid #edf0f5;text-align:left;font-size:13px;vertical-align:middle}th{background:#f8fafc;color:#64748b;font-size:10px;text-transform:uppercase;letter-spacing:.08em;font-weight:800}.table-wrap{overflow-x:auto;border-radius:16px}.row{display:flex;gap:14px;align-items:center;flex-wrap:wrap}.row>*{flex:1}.alert{padding:13px 16px;border-radius:12px;margin:0 0 16px;background:#dcfce7;color:#166534;border:1px solid #bbf7d0;font-size:14px}.alert.error{background:#fff1f2;color:#9f1239;border-color:#ffe4e6}.muted{color:var(--muted)}.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px}.stat{font-size:30px;font-weight:800;letter-spacing:-.04em;margin-top:8px;color:#14213d}.actions{display:flex;gap:6px;align-items:center;flex-wrap:wrap}.actions form{display:inline}.actions button{font-size:12px;padding:7px 10px}.pagination{padding:18px 4px}.pagination a,.pagination span{margin-right:8px}.auth{max-width:470px;margin:42px auto;padding:32px}.room-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px}.room-price{font-size:23px;font-weight:800;color:#14213d}.room-card{padding:0;overflow:hidden;display:flex;flex-direction:column}.room-card>img{width:100%;height:205px;object-fit:cover;background:#e2e8f0}.room-card-body{padding:20px;display:flex;flex-direction:column;align-items:flex-start;gap:8px;height:100%}.room-card-body h2,.room-card-body h3{margin:0;font-size:19px;font-weight:800;letter-spacing:-.025em}.room-card-body p{margin:0;line-height:1.6;font-size:13px}.section-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin:26px 0 15px}.section-header h2{font-size:22px;font-weight:800;letter-spacing:-.03em;margin:0}.feature-chip{display:inline-flex;align-items:center;padding:6px 10px;background:#eaf2ff;color:#285fc7;border-radius:999px;font-size:11px;font-weight:800;letter-spacing:.02em}.hero{border-radius:26px;padding:42px;background:linear-gradient(115deg,#14213d 0%,#1f3e70 58%,#3977e8 100%);color:#fff;overflow:hidden;position:relative;box-shadow:0 20px 45px #14213d20}.hero h1{font-size:clamp(32px,4vw,52px);line-height:1.08;letter-spacing:-.05em;font-weight:850;margin:18px 0}.hero-panel{border:1px solid #ffffff30;background:#ffffff12;backdrop-filter:blur(8px);padding:26px;border-radius:20px}.stat-box{background:#fff;border:1px solid var(--line);border-radius:16px;padding:20px}.stat-box .stat{font-size:25px}.badge-status{display:inline-flex;padding:5px 9px;border-radius:999px;background:#eff6ff;color:#1d4ed8;font-size:11px;font-weight:800;text-transform:capitalize}.admin-content-title{font-size:26px;letter-spacing:-.04em;font-weight:850;color:#14213d;margin:0}.admin-subtitle{font-size:13px;color:#64748b;margin-top:6px}.mobile-menu{display:none}
        @media(max-width:900px){.admin-sidebar{width:220px}.admin-main{margin-left:220px}.admin-topbar{padding:0 22px}.page-wrap{padding:24px 22px}}@media(max-width:700px){.admin-sidebar{position:static;width:100%;padding:15px;display:block}.admin-sidebar .side-links{display:flex;gap:5px;overflow-x:auto}.admin-sidebar .side-label,.admin-sidebar .sidebar-footer{display:none}.side-link{white-space:nowrap;padding:9px 11px}.admin-main{margin-left:0}.admin-topbar{height:auto;padding:16px;align-items:flex-start}.page-wrap{padding:18px 14px}.container{padding:0}.hero{padding:25px}.auth{margin:20px auto;padding:23px}.card{padding:17px}.room-card{padding:0}.section-header{align-items:flex-start;flex-direction:column}.row>*{min-width:100%}.row .btn{min-width:auto}}
    </style>
</head>
<body>
@php($isAdminArea = auth()->check() && auth()->user()->isAdmin() && request()->is('admin*'))
<div class="app-shell">
    @if($isAdminArea)
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-2 no-underline text-white mb-7">
                <span class="brand-mark">⌂</span><span><strong class="block text-[15px] tracking-tight">StayEase</strong><small class="text-[10px] tracking-[.16em] uppercase text-slate-400">Management suite</small></span>
            </a>
            <div class="side-label">Workspace</div>
            <nav class="side-links">
                <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><span>▦</span> Overview</a>
                <a class="side-link {{ request()->routeIs('admin.hotels.*') ? 'active' : '' }}" href="{{ route('admin.hotels.index') }}"><span>⌂</span> Hotels</a>
                <a class="side-link {{ request()->routeIs('admin.floors.*') ? 'active' : '' }}" href="{{ route('admin.floors.index') }}"><span>▤</span> Floors</a>
                <a class="side-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}" href="{{ route('admin.rooms.index') }}"><span>▣</span> Rooms</a>
                <a class="side-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}"><span>▧</span> Reservations</a>
                <a class="side-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><span>♙</span> Customers & users</a>
            </nav>
            <div class="sidebar-footer mt-auto pt-5 border-t border-slate-700/70">
                <a class="side-link" href="{{ route('home') }}"><span>↗</span> View customer website</a>
                <div class="flex items-center gap-3 px-3 py-4 mt-3">
                    <div class="w-9 h-9 rounded-full bg-blue-500/20 text-blue-200 grid place-items-center font-bold">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                    <div class="min-w-0 flex-1"><p class="text-sm text-white font-semibold truncate">{{ auth()->user()->name }}</p><p class="text-xs text-slate-400">Administrator</p></div>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button title="Sign out" class="text-slate-400 hover:text-white">↪</button></form>
                </div>
            </div>
        </aside>
        <div class="admin-main">
            <header class="admin-topbar">
                <div><p class="text-xs text-slate-400 mb-1">StayEase / Administration</p><h1 class="font-bold text-slate-800 text-sm">@yield('heading', 'Hotel operations')</h1></div>
                <div class="flex items-center gap-3"><span class="hidden sm:inline text-xs text-slate-500">{{ now()->format('D, d M Y') }}</span><div class="w-9 h-9 rounded-full bg-blue-50 text-blue-700 grid place-items-center font-bold">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div></div>
            </header>
            <main class="page-wrap">
    @else
        <header class="bg-white border-b border-slate-200/80">
            <nav class="max-w-[1440px] mx-auto px-5 lg:px-8 min-h-[76px] flex items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3 no-underline text-slate-900">
                    <span class="brand-mark">⌂</span><span><strong class="block text-[16px] tracking-tight">StayEase</strong><small class="text-[10px] uppercase tracking-[.16em] text-slate-400">Stay better. Travel well.</small></span>
                </a>
                <div class="flex items-center gap-1 sm:gap-2 flex-wrap justify-end">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a class="top-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Admin workspace</a>
                        @endif
                        <a class="top-link {{ request()->routeIs('customer.rooms.*') ? 'active' : '' }}" href="{{ route('customer.rooms.index') }}">Rooms</a>
                        <a class="top-link {{ request()->routeIs('customer.bookings.*') ? 'active' : '' }}" href="{{ route('customer.bookings.index') }}">My bookings</a>
                        <span class="hidden md:inline text-xs text-slate-500 px-2">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn gray">Sign out</button></form>
                    @else
                        <a class="top-link" href="{{ route('login') }}">Sign in</a><a class="btn" href="{{ route('register') }}">Create account <span>↗</span></a>
                    @endauth
                </div>
            </nav>
        </header>
        <main class="max-w-[1440px] mx-auto px-5 lg:px-8 py-8">
    @endif
            @if(session('success'))<div class="alert">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert error">{{ session('error') }}</div>@endif
            @if($errors->any())<div class="alert error"><strong>Please fix these errors:</strong><ul class="list-disc ml-5 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </main>
        @if($isAdminArea)
        </div>
        @endif
</div>
</body>
</html>