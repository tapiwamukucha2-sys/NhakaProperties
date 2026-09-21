<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600,700&family=Archivo:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{ --forest:#123A6B; --forest-dark:#0B2545; --gold:#C08A28; --gold-light:#DBAE5A; --ink:#131C2B; --paper:#F2F5F9; --paper-2:#FFFFFF; --line:rgba(19,28,43,0.12); }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{font-family:'Archivo', sans-serif; color:var(--ink); background:var(--paper); display:flex; min-height:100vh;}
  h1,h2,h3{font-family:'Fraunces', serif; font-weight:600;}
  a{color:inherit; text-decoration:none;}

  /* ---------- SIDEBAR ---------- */
  .sidebar{width:230px; flex-shrink:0; background:var(--forest-dark); color:rgba(255,255,255,0.75); display:flex; flex-direction:column; position:sticky; top:0; height:100vh; overflow-y:auto;}
  .sidebar .brand{display:flex; align-items:center; gap:10px; padding:22px 20px; border-bottom:1px solid rgba(255,255,255,0.1);}
  .sidebar .brand .name{font-family:'Fraunces',serif; font-weight:700; font-size:16px; color:#fff; line-height:1.1;}
  .sidebar .brand .tag{font-size:10px; letter-spacing:.08em; text-transform:uppercase; color:var(--gold-light);}
  .sidebar nav{flex:1; padding:14px 10px;}
  .sidebar nav a{display:flex; align-items:center; gap:11px; padding:10px 12px; border-radius:8px; font-size:14px; font-weight:500; margin-bottom:2px;}
  .sidebar nav a:hover{background:rgba(255,255,255,0.06); color:#fff;}
  .sidebar nav a.active{background:var(--gold); color:var(--forest-dark); font-weight:700;}
  .sidebar nav a svg{width:17px; height:17px; flex-shrink:0;}
  .sidebar .foot{padding:14px 20px; border-top:1px solid rgba(255,255,255,0.1);}
  .sidebar .foot a{font-size:13px; color:rgba(255,255,255,0.6);}
  .sidebar .foot a:hover{color:#fff;}

  /* ---------- MAIN ---------- */
  .main{flex:1; min-width:0;}
  .topbar{background:var(--paper-2); border-bottom:1px solid var(--line); padding:16px 30px; display:flex; align-items:center; justify-content:space-between;}
  .topbar .visit{font-size:13.5px; font-weight:600; color:var(--forest); display:flex; align-items:center; gap:6px;}
  .topbar .user{display:flex; align-items:center; gap:10px; font-size:13.5px; font-weight:600;}
  .topbar .avatar{width:30px; height:30px; border-radius:50%; background:var(--gold); display:flex; align-items:center; justify-content:center; color:var(--forest-dark); font-weight:700; font-size:13px;}
  .content{padding:30px;}
  .page-head{display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px; margin-bottom:26px;}
  .page-head h1{font-size:23px;}

  .btn{display:inline-block; padding:11px 20px; border-radius:7px; font-weight:600; font-size:13.5px; cursor:pointer; border:none;}
  .btn-primary{background:var(--forest); color:#fff;}
  .btn-primary:hover{background:var(--forest-dark);}

  .status-msg{background:rgba(18,58,107,0.08); border:1px solid rgba(18,58,107,0.25); color:var(--forest); font-size:13.5px; font-weight:600; padding:12px 16px; border-radius:8px; margin-bottom:24px;}

  .stat-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:30px;}
  @media(max-width:1000px){ .stat-grid{grid-template-columns:repeat(2,1fr);} }
  .stat-card{background:var(--paper-2); border:1px solid var(--line); border-radius:12px; padding:20px;}
  .stat-card .label{display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:700; color:rgba(19,28,43,0.55); text-transform:uppercase; letter-spacing:.03em;}
  .stat-card .num{font-family:'Fraunces',serif; font-size:32px; font-weight:600; margin-top:8px;}
  .stat-card .sub{font-size:12.5px; color:rgba(19,28,43,0.5); margin-top:2px;}
  .stat-card a{display:inline-block; margin-top:12px; font-size:13px; font-weight:700; color:var(--forest);}
  .stat-card a:hover{text-decoration:underline;}

  .panel{background:var(--paper-2); border:1px solid var(--line); border-radius:12px; overflow:hidden;}
  .panel-head{padding:16px 22px; border-bottom:1px solid var(--line); font-weight:700; font-size:15px;}
  table{width:100%; font-size:13.5px; border-collapse:collapse;}
  thead tr{text-align:left; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.03em; color:rgba(19,28,43,0.5); border-bottom:1px solid var(--line);}
  th, td{padding:14px 22px;}
  tbody tr{border-bottom:1px solid var(--line);}
  tbody tr:last-child{border-bottom:none;}
  .badge{display:inline-flex; font-size:11.5px; font-weight:700; padding:3px 10px; border-radius:20px;}
  .badge-green{background:rgba(18,58,107,0.1); color:var(--forest);}
  .badge-gold{background:rgba(192,138,40,0.15); color:var(--gold);}
  .badge-gray{background:rgba(19,28,43,0.08); color:rgba(19,28,43,0.6);}
  .badge-red{background:#fee2e2; color:#b91c1c;}
  .link-action{font-weight:700; font-size:13px; cursor:pointer; background:none; border:none; padding:0;}
  .link-forest{color:var(--forest);}
  .link-red{color:#dc2626;}

  @yield('styles')
</style>
</head>
<body>

<aside class="sidebar">
  <div class="brand">
    <x-logo :size="30" />
    <div>
      <div class="name">{{ config('app.name') }}</div>
      <div class="tag">Admin</div>
    </div>
  </div>
  <nav>
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
      Dashboard
    </a>
    <a href="{{ route('admin.properties.index') }}" class="{{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V20a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V9.5"/></svg>
      Properties
    </a>
    <a href="{{ route('admin.hero-slides.index') }}" class="{{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="14" rx="2"/><path d="m3 15 5-5 4 4 4-4 5 5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      Hero Slides
    </a>
    <a href="{{ route('admin.agents.index') }}" class="{{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3.2"/><path d="M2.5 20c0-3.6 3-6 6.5-6s6.5 2.4 6.5 6" stroke-linecap="round"/><circle cx="18" cy="9" r="2.4"/><path d="M15.8 14.2c2.6.4 4.7 2.3 4.7 5.8" stroke-linecap="round"/></svg>
      Agents & Users
    </a>
    <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h10M4 18h7" stroke-linecap="round"/></svg>
      Homepage Copy
    </a>
  </nav>
  <div class="foot">
    <form action="{{ route('admin.logout') }}" method="POST">
      @csrf
      <button type="submit" style="background:none; border:none; color:inherit; font-size:13px; cursor:pointer; display:flex; align-items:center; gap:8px;">
        <svg style="width:15px;height:15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" stroke-linecap="round"/><path d="M16 17l5-5-5-5M21 12H9" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Log out
      </button>
    </form>
  </div>
</aside>

<div class="main">
  <div class="topbar">
    <a href="{{ route('home') }}" class="visit" target="_blank">
      <svg style="width:15px;height:15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18 14 14 0 0 1 0-18Z"/></svg>
      Visit Site
    </a>
    <div class="user">
      <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
      {{ auth()->user()->name }}
    </div>
  </div>

  <div class="content">
    <div class="page-head">
      <h1>@yield('page-title')</h1>
      @yield('page-actions')
    </div>

    @if (session('status'))
      <div class="status-msg">{{ session('status') }}</div>
    @endif

    @yield('content')
  </div>
</div>

</body>
</html>
