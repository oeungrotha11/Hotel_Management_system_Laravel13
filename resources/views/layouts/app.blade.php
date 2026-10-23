<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>@yield('title','StayEase Hotel Management')</title>
<style>
:root{--navy:#14213d;--blue:#2563eb;--bg:#f4f7fb;--muted:#64748b;--line:#e2e8f0}*{box-sizing:border-box}body{margin:0;font-family:Arial,sans-serif;background:var(--bg);color:#172033}.nav{background:var(--navy);color:white;padding:16px 5%;display:flex;align-items:center;gap:22px;flex-wrap:wrap}.nav strong{font-size:19px;margin-right:auto}.nav a{color:white;text-decoration:none}.nav form{margin:0}.nav button{background:transparent;color:white;border:1px solid #ffffff80;padding:7px 12px;border-radius:7px;cursor:pointer}.container{max-width:1150px;margin:28px auto;padding:0 18px}.card{background:white;border:1px solid var(--line);border-radius:14px;padding:22px;margin-bottom:18px;box-shadow:0 4px 18px #0f172a08}.btn{display:inline-block;border:0;border-radius:8px;padding:10px 14px;background:var(--blue);color:white;text-decoration:none;cursor:pointer;font-size:14px}.btn.gray{background:#475569}.btn.red{background:#dc2626}.btn.green{background:#15803d}input,select,textarea{width:100%;padding:11px;border:1px solid #cbd5e1;border-radius:8px;margin-top:6px;font:inherit}label{font-weight:600;font-size:14px;display:block;margin-bottom:14px}table{width:100%;border-collapse:collapse;background:white}th,td{padding:13px 12px;border-bottom:1px solid var(--line);text-align:left;font-size:14px}th{background:#f8fafc;color:#475569}.table-wrap{overflow-x:auto}.row{display:flex;gap:12px;align-items:center;flex-wrap:wrap}.row>*{flex:1}.alert{padding:12px 15px;border-radius:8px;margin-bottom:14px;background:#dcfce7;color:#166534}.alert.error{background:#fee2e2;color:#991b1b}.muted{color:var(--muted)}.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px}.stat{font-size:30px;font-weight:bold;margin-top:8px}.actions{display:flex;gap:6px;align-items:center;flex-wrap:wrap}.actions form{display:inline}.actions button{font-size:12px;padding:7px}.pagination{padding:15px}.pagination a,.pagination span{margin-right:8px}.auth{max-width:450px;margin:50px auto}.room-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px}.room-price{font-size:22px;font-weight:bold;color:var(--navy)}@media(max-width:600px){.nav{gap:12px}.nav strong{width:100%}.card{padding:15px}}
</style></head><body>
<nav class="nav"><strong>🏨 StayEase HMS</strong>
@auth
@if(auth()->user()->isAdmin())
<a href="{{ route('admin.dashboard') }}">Admin dashboard</a><a href="{{ route('admin.hotels.index') }}">Hotels</a><a href="{{ route('admin.floors.index') }}">Floors</a><a href="{{ route('admin.rooms.index') }}">Manage rooms</a><a href="{{ route('admin.bookings.index') }}">All bookings</a><a href="{{ route('admin.users.index') }}">Users</a>
@else
<a href="{{ route('home') }}">Home</a><a href="{{ route('customer.rooms.index') }}">Browse rooms</a><a href="{{ route('customer.bookings.index') }}">My bookings</a>
@endif
<span>{{ auth()->user()->name }}</span><form method="POST" action="{{ route('logout') }}">@csrf<button>Logout</button></form>
@else <a href="{{ route('login') }}">Login</a><a href="{{ route('register') }}">Register</a>@endauth
</nav><main class="container">
@if(session('success'))<div class="alert">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert error">{{ session('error') }}</div>@endif
@if($errors->any())<div class="alert error"><strong>Please fix these errors:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@yield('content')
</main></body></html>
