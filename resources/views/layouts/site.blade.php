<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@php
    $metaTitle = trim($__env->yieldContent('title')) ?: config('app.name').' — Find Property Across Zimbabwe';
    $metaDescription = trim($__env->yieldContent('description')) ?: 'Search verified rentals, houses, stands and commercial space across Zimbabwe — direct from landlords and registered agents.';
    $metaImage = trim($__env->yieldContent('image')) ?: asset('images/hero/estate-day.jpg');
@endphp
<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:image" content="{{ $metaImage }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $metaImage }}">
<link rel="canonical" href="{{ url()->current() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Archivo:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --ink:#131C2B;
    --paper:#F2F5F9;
    --paper-2:#FFFFFF;
    --forest:#123A6B;
    --forest-dark:#0B2545;
    --gold:#C08A28;
    --gold-light:#DBAE5A;
    --brick:#3E6FA6;
    --line: rgba(19,28,43,0.12);
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html{scroll-behavior:smooth;}
  body{
    background:var(--paper);
    color:var(--ink);
    font-family:'Archivo', sans-serif;
    line-height:1.5;
    -webkit-font-smoothing:antialiased;
  }
  h1,h2,h3, .display{
    font-family:'Fraunces', serif;
    font-weight:600;
    letter-spacing:-0.01em;
    line-height:1.08;
  }
  a{color:inherit; text-decoration:none;}
  img{max-width:100%; display:block;}
  .wrap{max-width:1180px; margin:0 auto; padding:0 32px;}
  a, button, select, input, .btn, .cat-card, .card, .price-card{
    transition:color .18s ease, background-color .18s ease, border-color .18s ease, transform .18s ease, box-shadow .18s ease, opacity .3s ease;
  }
  @keyframes fadeUp{ from{opacity:0; transform:translateY(14px);} to{opacity:1; transform:translateY(0);} }
  .reveal{animation:fadeUp .7s ease both;}
  .reveal-delay-1{animation-delay:.08s;}
  .reveal-delay-2{animation-delay:.16s;}
  .reveal-delay-3{animation-delay:.24s;}

  /* ---------- TOP BAR ---------- */
  .topbar{background:var(--forest-dark); color:rgba(255,255,255,0.85); font-size:13px;}
  .topbar .wrap{display:flex; align-items:center; justify-content:space-between; padding:9px 32px; flex-wrap:wrap; gap:8px;}
  .topbar .contacts{display:flex; align-items:center; gap:20px; flex-wrap:wrap;}
  .topbar .contacts a{display:inline-flex; align-items:center; gap:6px; color:rgba(255,255,255,0.85);}
  .topbar .contacts a:hover{color:#fff;}
  .topbar .social{display:flex; align-items:center; gap:14px;}
  .topbar .social span{color:rgba(255,255,255,0.6); font-weight:600; letter-spacing:.02em; margin-right:2px;}
  .topbar .social a{color:rgba(255,255,255,0.85); display:inline-flex;}
  .topbar .social a:hover{color:var(--gold-light);}
  .icon{width:15px; height:15px; display:block;}

  /* ---------- HEADER ---------- */
  header{padding:22px 0 20px; border-bottom:1px solid var(--line); background:var(--paper-2);}
  header .wrap{display:flex; align-items:center; justify-content:space-between;}
  .logo{font-family:'Fraunces', serif; font-size:24px; font-weight:700; display:flex; align-items:center; gap:10px;}
  nav{display:flex; align-items:center; gap:30px;}
  nav .links{display:flex; gap:28px; font-size:15px; font-weight:500;}
  nav .links a{padding-bottom:4px; border-bottom:1px solid transparent;}
  nav .links a:hover, nav .links a.active{border-color:var(--ink);}
  .btn{display:inline-block; padding:12px 22px; border-radius:6px; font-weight:600; font-size:14.5px; cursor:pointer; border:none;}
  .btn-primary{background:var(--forest); color:#fff;}
  .btn-primary:hover{transform:translateY(-1px); box-shadow:0 8px 18px rgba(18,58,107,0.28); background:var(--forest-dark);}
  .btn-ghost{border:1px solid var(--ink); background:transparent;}
  .btn-ghost:hover{background:var(--ink); color:#fff;}
  .btn-row{display:flex; align-items:center; gap:10px;}
  @media(max-width:860px){ nav .links{display:none;} }

  /* ---------- PAGE HERO (simple, non-home pages) ---------- */
  .page-hero{background:var(--forest); color:#fff; padding:60px 0 50px;}
  .page-hero h1{font-size:clamp(30px,4vw,44px);}
  .page-hero p{margin-top:14px; font-size:16px; color:rgba(255,255,255,0.82); max-width:56ch;}
  .breadcrumb{font-size:13px; color:rgba(255,255,255,0.6); margin-bottom:14px;}
  .breadcrumb a:hover{color:#fff;}

  /* ---------- CATEGORY / CARD SHARED ---------- */
  .section-head{display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:30px; gap:20px; flex-wrap:wrap;}
  .section-head h2{font-size:clamp(28px,3.4vw,38px);}
  .section-head .sub{color:rgba(19,28,43,0.65); font-size:15px; margin-top:6px;}

  .listing-grid{display:grid; grid-template-columns:repeat(3, 1fr); gap:22px;}
  @media(max-width:900px){ .listing-grid{grid-template-columns:1fr 1fr;} }
  @media(max-width:600px){ .listing-grid{grid-template-columns:1fr;} }

  .card{background:var(--paper-2); border:1px solid var(--line); border-radius:12px; overflow:hidden; display:block;}
  .card:hover{transform:translateY(-3px); box-shadow:0 16px 30px -20px rgba(19,28,43,0.4);}
  .card .thumb{height:170px; position:relative; background:linear-gradient(150deg, var(--forest), #4a6b58); overflow:hidden;}
  .card .thumb img{width:100%; height:100%; object-fit:cover;}
  .card:nth-child(2) .thumb{background:linear-gradient(150deg,var(--brick),#7fa3cc);}
  .card:nth-child(3) .thumb{background:linear-gradient(150deg,var(--gold),var(--gold-light));}
  .card:nth-child(4) .thumb{background:linear-gradient(150deg,#2c5a92,var(--forest));}
  .card:nth-child(5) .thumb{background:linear-gradient(150deg,#7fa3cc,var(--brick));}
  .card:nth-child(6) .thumb{background:linear-gradient(150deg,var(--gold-light),var(--gold));}
  .badge{position:absolute; top:12px; left:12px; background:rgba(255,255,255,0.95); font-size:11.5px; font-weight:700; padding:5px 10px; border-radius:20px; display:flex; align-items:center; gap:5px;}
  .badge .v{width:6px; height:6px; border-radius:50%; background:var(--forest);}
  .price-tag{position:absolute; bottom:12px; left:12px; background:var(--ink); color:#fff; font-weight:700; font-size:14.5px; padding:6px 12px; border-radius:8px;}
  .card .body{padding:18px 18px 20px;}
  .card h3{font-size:17px; font-weight:600; font-family:'Archivo',sans-serif;}
  .card .loc{font-size:13.5px; color:rgba(19,28,43,0.6); margin-top:4px;}
  .card .meta{margin-top:14px; padding-top:14px; border-top:1px solid var(--line); display:flex; gap:16px; font-size:13px; color:rgba(19,28,43,0.7);}

  .filter-row{display:flex; gap:10px; flex-wrap:wrap; margin-bottom:30px;}
  .filter-chip{padding:9px 18px; border-radius:20px; border:1px solid var(--line); background:var(--paper-2); font-size:13.5px; font-weight:600; cursor:pointer;}
  .filter-chip.active{background:var(--forest); color:#fff; border-color:var(--forest);}

  /* ---------- PAGINATION ---------- */
  .pagination{display:flex; align-items:center; justify-content:center; gap:6px; margin-top:40px; flex-wrap:wrap;}
  .pagination a, .pagination span{display:inline-flex; align-items:center; justify-content:center; min-width:38px; height:38px; padding:0 12px; border-radius:8px; border:1px solid var(--line); background:var(--paper-2); font-size:13.5px; font-weight:600; color:var(--ink);}
  .pagination a:hover{border-color:var(--forest); color:var(--forest);}
  .pagination .active span{background:var(--forest); color:#fff; border-color:var(--forest);}
  .pagination .disabled span{color:rgba(19,28,43,0.35); cursor:default;}

  /* ---------- TRUST ---------- */
  .trust{padding:70px 0; background:var(--forest); color:#fff;}
  .trust-grid{display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center;}
  @media(max-width:860px){ .trust-grid{grid-template-columns:1fr; gap:30px;} }
  .trust h2{font-size:clamp(28px,3.4vw,40px); max-width:12ch;}
  .trust .lede{margin-top:18px; font-size:16px; color:rgba(255,255,255,0.8); max-width:44ch;}
  .trust-points{margin-top:28px; display:flex; flex-direction:column; gap:18px;}
  .trust-point{display:flex; gap:14px;}
  .trust-point .num{font-family:'Fraunces', serif; font-weight:600; font-size:20px; color:var(--gold-light); flex-shrink:0; width:30px;}
  .trust-point p{font-size:14.5px; color:rgba(255,255,255,0.82);}
  .trust-point b{color:#fff; display:block; margin-bottom:2px; font-size:15.5px;}
  .trust-visual{background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.16); border-radius:16px; padding:34px;}
  .verify-card{background:var(--paper-2); color:var(--ink); border-radius:12px; padding:22px;}
  .verify-card .top{display:flex; justify-content:space-between; align-items:flex-start;}
  .verify-card .agent{width:44px; height:44px; border-radius:50%; background:var(--gold); object-fit:cover;}
  .verify-badge{display:inline-flex; align-items:center; gap:6px; background:rgba(18,58,107,0.1); color:var(--forest); font-size:12px; font-weight:700; padding:5px 10px; border-radius:20px; margin-top:14px;}
  .verify-card h4{margin-top:16px; font-size:16.5px; font-family:'Archivo'; font-weight:700;}
  .verify-card .id-line{font-size:12.5px; color:rgba(19,28,43,0.55); margin-top:4px;}

  /* ---------- PRICING ---------- */
  .pricing{padding:80px 0;}
  .price-grid{display:grid; grid-template-columns:repeat(3,1fr); gap:20px;}
  @media(max-width:860px){ .price-grid{grid-template-columns:1fr;} }
  .price-card{border:1px solid var(--line); border-radius:14px; padding:32px 28px; background:var(--paper-2); display:flex; flex-direction:column;}
  .price-card:hover{transform:translateY(-3px); box-shadow:0 18px 30px -20px rgba(19,28,43,0.35);}
  .price-card.featured{background:var(--ink); color:var(--paper); border-color:var(--ink); position:relative;}
  .featured-tag{position:absolute; top:-13px; left:28px; background:var(--gold); color:var(--forest-dark); font-size:12px; font-weight:700; padding:4px 12px; border-radius:20px;}
  .price-card .tier{font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; color:var(--forest);}
  .price-card.featured .tier{color:var(--gold-light);}
  .price-card .amount{font-family:'Fraunces', serif; font-weight:600; font-size:40px; margin-top:10px;}
  .price-card .amount span{font-size:15px; font-weight:500; font-family:'Archivo';}
  .price-card .desc{font-size:14px; margin-top:10px; opacity:.8; min-height:40px;}
  .price-card ul{margin-top:22px; display:flex; flex-direction:column; gap:11px; flex:1;}
  .price-card li{font-size:14px; padding-left:20px; position:relative;}
  .price-card li::before{content:"—"; position:absolute; left:0; color:var(--gold);}
  .price-card .btn{margin-top:26px; text-align:center;}
  .price-card.featured .btn{background:var(--gold); color:var(--forest-dark);}
  .price-card:not(.featured) .btn{background:var(--forest); color:#fff;}

  /* ---------- NEWSLETTER ---------- */
  .newsletter{background:var(--forest); padding:26px 0;}
  .newsletter .wrap{display:flex; align-items:center; justify-content:space-between; gap:24px; flex-wrap:wrap;}
  .newsletter .copy{display:flex; align-items:center; gap:14px; color:#fff;}
  .newsletter .copy .icon-circle{width:38px; height:38px; border-radius:50%; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; flex-shrink:0;}
  .newsletter h4{font-size:15.5px; font-weight:700;}
  .newsletter p{font-size:13px; color:rgba(255,255,255,0.75); margin-top:2px;}
  .newsletter-form{display:flex; gap:0; flex:1; max-width:420px;}
  .newsletter-form input{flex:1; border:none; padding:13px 16px; border-radius:8px 0 0 8px; font-family:inherit; font-size:14px;}
  .newsletter-form input:focus{outline:none;}
  .newsletter-form button{background:var(--gold); color:var(--forest-dark); border:none; padding:0 22px; font-weight:700; font-size:14px; border-radius:0 8px 8px 0; cursor:pointer;}
  .newsletter-form button:hover{background:var(--gold-light);}

  /* ---------- FOOTER ---------- */
  footer{background:var(--forest-dark); color:rgba(255,255,255,0.75); padding:54px 0 26px;}
  .foot-grid{display:grid; grid-template-columns:1.4fr 1fr 1fr 1.2fr; gap:40px;}
  @media(max-width:860px){ .foot-grid{grid-template-columns:1fr 1fr; row-gap:34px;} }
  footer h5{color:var(--gold-light); font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:.05em; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid rgba(255,255,255,0.14);}
  footer ul{list-style:none;}
  footer ul li{margin-bottom:10px; font-size:14px;}
  footer ul li a:hover{color:#fff;}
  footer .brand-desc{font-size:13.5px; color:rgba(255,255,255,0.65); margin-top:12px; max-width:34ch;}
  footer .foot-social{display:flex; gap:10px; margin-top:18px;}
  footer .foot-social a{width:34px; height:34px; border-radius:50%; background:rgba(255,255,255,0.08); display:flex; align-items:center; justify-content:center; color:#fff;}
  footer .foot-social a:hover{background:var(--gold); color:var(--forest-dark);}
  footer .contact-item{display:flex; gap:10px; margin-bottom:16px; font-size:13.5px;}
  footer .contact-item .k{font-size:11px; text-transform:uppercase; letter-spacing:.04em; color:rgba(255,255,255,0.5); display:block; margin-bottom:2px;}
  .foot-bottom{margin-top:44px; padding-top:22px; border-top:1px solid rgba(255,255,255,0.12); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; font-size:12.5px; color:rgba(255,255,255,0.5);}
  .foot-bottom a:hover{color:#fff;}

  /* ---------- FLOATING ---------- */
  .float-stack{position:fixed; right:22px; bottom:22px; z-index:50; display:flex; flex-direction:column; gap:12px; align-items:flex-end;}
  .float-btn{width:50px; height:50px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 10px 24px -8px rgba(19,28,43,0.5); border:none; cursor:pointer;}
  .float-whatsapp{background:#25D366; color:#fff;}
  .float-top{background:var(--forest); color:#fff; opacity:0; pointer-events:none; transform:translateY(10px);}
  .float-top.visible{opacity:1; pointer-events:auto; transform:translateY(0);}

  /* ---------- TOAST ---------- */
  .toast{position:fixed; left:50%; bottom:30px; transform:translate(-50%, 20px); background:var(--ink); color:#fff; padding:13px 22px; border-radius:8px; font-size:14px; font-weight:600; opacity:0; pointer-events:none; transition:opacity .3s ease, transform .3s ease; z-index:60; box-shadow:0 14px 30px -10px rgba(0,0,0,0.4);}
  .toast.show{opacity:1; transform:translate(-50%, 0);}

  @yield('styles')
</style>
</head>
<body>

<div class="topbar">
  <div class="wrap">
    <div class="contacts">
      <a href="mailto:support@nhaka.co.zw">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z" stroke-linecap="round" stroke-linejoin="round"/><path d="m4 6 8 7 8-7" stroke-linecap="round" stroke-linejoin="round"/></svg>
        support@nhaka.co.zw
      </a>
      <a href="https://wa.me/263776651578" target="_blank" rel="noopener">
        <svg class="icon" viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 14.4c-.3-.1-1.7-.8-1.9-.9-.3-.1-.4-.1-.6.1-.2.3-.7.9-.8 1-.2.2-.3.2-.5.1-.3-.1-1.2-.4-2.2-1.4-.8-.7-1.4-1.6-1.5-1.9-.2-.3 0-.5.1-.6l.4-.5c.1-.1.2-.3.2-.4.1-.2 0-.3 0-.4-.1-.1-.6-1.4-.8-1.9-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.4.1-.6.3-.2.3-.8.8-.8 1.9s.8 2.2 1 2.4c.1.1 1.7 2.6 4.1 3.6.6.2 1 .4 1.4.5.6.2 1.1.1 1.5.1.5-.1 1.7-.7 1.9-1.3.2-.6.2-1.1.2-1.2 0-.1-.2-.2-.5-.3z"/><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm0 18.2a8.2 8.2 0 0 1-4.2-1.1l-.3-.2-2.9.8.8-2.8-.2-.3A8.2 8.2 0 1 1 12 20.2Z"/></svg>
        +263 77 665 1578
      </a>
    </div>
    <div class="social">
      <span>Follow us:</span>
      <a href="#" aria-label="Facebook"><svg class="icon" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.8h2.6l.4-3H13.5V8.3c0-.9.2-1.5 1.5-1.5h1.6V4.1C16.3 4 15.3 4 14.2 4c-2.4 0-4 1.5-4 4.1v2.1H7.6v3h2.6V21h3.3Z"/></svg></a>
      <a href="#" aria-label="X"><svg class="icon" viewBox="0 0 24 24" fill="currentColor"><path d="M18.9 3H21l-6.6 7.5L22 21h-6.4l-5-6.5L4.7 21H2.6l7-8-7.4-10H8.7l4.5 6 5.7-6Zm-1.1 16.2h1.2L7.3 4.7H6l11.8 14.5Z"/></svg></a>
      <a href="#" aria-label="Instagram"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></svg></a>
      <a href="#" aria-label="LinkedIn"><svg class="icon" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.6H3.3V21h3.6V8.6ZM5.1 3a2.1 2.1 0 1 0 0 4.2 2.1 2.1 0 0 0 0-4.2ZM21 21v-7c0-3.4-1.8-5-4.3-5-2 0-2.9 1.1-3.4 1.9V9H9.7c0 .9 0 12 0 12h3.6v-6.7c0-.4 0-.7.1-1 .3-.7.9-1.5 2-1.5 1.4 0 2 1.1 2 2.6V21H21Z"/></svg></a>
    </div>
  </div>
</div>

<header>
  <div class="wrap">
    <a href="{{ route('home') }}" class="logo"><x-logo /> {{ config('app.name') }}</a>
    <nav>
      <div class="links">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('browse') }}" class="{{ request()->routeIs('browse') ? 'active' : '' }}">Browse</a>
        <a href="{{ route('map') }}" class="{{ request()->routeIs('map') ? 'active' : '' }}">Map</a>
        <a href="{{ route('agents') }}" class="{{ request()->routeIs('agents') ? 'active' : '' }}">Agents</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
      </div>
      <div class="btn-row">
        @auth
          <span style="font-size:13.5px; font-weight:600; color:rgba(19,28,43,0.6);">{{ auth()->user()->name }}</span>
          <a class="btn btn-ghost" href="{{ route('dashboard') }}">Dashboard</a>
          <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="btn btn-ghost">Log Out</button>
          </form>
        @else
          <a class="btn btn-ghost" href="{{ route('login') }}">Sign In</a>
          <a class="btn btn-primary" href="{{ route('register') }}">Get Started</a>
        @endauth
      </div>
    </nav>
  </div>
</header>

@yield('content')

<div class="newsletter">
  <div class="wrap">
    <div class="copy">
      <span class="icon-circle">
        <svg class="icon" style="width:18px;height:18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z" stroke-linecap="round" stroke-linejoin="round"/><path d="m4 6 8 7 8-7" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </span>
      <div>
        <h4>Stay updated with the latest listings</h4>
        <p>Get new properties delivered to your inbox weekly.</p>
      </div>
    </div>
    <form class="newsletter-form" id="newsletterForm">
      <input type="email" name="email" placeholder="Your email address" required>
      <button type="submit">Subscribe</button>
    </form>
  </div>
</div>

<footer>
  <div class="wrap">
    <div class="foot-grid">
      <div>
        <div class="logo" style="color:#fff; font-size:20px;"><x-logo :size="26" /> {{ config('app.name') }}</div>
        <p class="brand-desc">{{ config('app.name') }} helps people discover rental and sale properties across Zimbabwe — verified listings, direct landlord and agent contact, no middle-men.</p>
        <div class="foot-social">
          <a href="#" aria-label="Facebook"><svg class="icon" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.8h2.6l.4-3H13.5V8.3c0-.9.2-1.5 1.5-1.5h1.6V4.1C16.3 4 15.3 4 14.2 4c-2.4 0-4 1.5-4 4.1v2.1H7.6v3h2.6V21h3.3Z"/></svg></a>
          <a href="#" aria-label="X"><svg class="icon" viewBox="0 0 24 24" fill="currentColor"><path d="M18.9 3H21l-6.6 7.5L22 21h-6.4l-5-6.5L4.7 21H2.6l7-8-7.4-10H8.7l4.5 6 5.7-6Zm-1.1 16.2h1.2L7.3 4.7H6l11.8 14.5Z"/></svg></a>
          <a href="#" aria-label="Instagram"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></svg></a>
          <a href="https://wa.me/263776651578" target="_blank" rel="noopener" aria-label="WhatsApp"><svg class="icon" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm0 18.2a8.2 8.2 0 0 1-4.2-1.1l-.3-.2-2.9.8.8-2.8-.2-.3A8.2 8.2 0 1 1 12 20.2Z"/></svg></a>
        </div>
      </div>
      <div>
        <h5>For House-Hunters</h5>
        <ul>
          <li><a href="{{ route('browse') }}">Browse Rentals</a></li>
          <li><a href="{{ route('browse') }}?category=buy">Buy a Home</a></li>
          <li><a href="{{ route('map') }}">Map View</a></li>
          <li><a href="{{ route('about') }}">About Us</a></li>
        </ul>
      </div>
      <div>
        <h5>For Owners</h5>
        <ul>
          <li><a href="{{ route('register') }}">For Landlords</a></li>
          <li><a href="{{ route('agents') }}">For Agents</a></li>
          <li><a href="{{ route('home') }}#list">Pricing</a></li>
          <li><a href="{{ route('home') }}#list">List a Property</a></li>
        </ul>
      </div>
      <div>
        <h5>Get in Touch</h5>
        <div class="contact-item">
          <div><span class="k">Phone / WhatsApp</span>+263 77 665 1578</div>
        </div>
        <div class="contact-item">
          <div><span class="k">Email</span>support@nhaka.co.zw</div>
        </div>
        <div class="contact-item">
          <div><span class="k">Head Office</span>Harare, Zimbabwe</div>
        </div>
      </div>
    </div>

    <div class="foot-bottom">
      <span>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
      <div style="display:flex; gap:20px;">
        <a href="{{ route('terms') }}">Terms</a>
        <a href="{{ route('privacy') }}">Privacy</a>
        <a href="{{ route('cookies') }}">Cookies</a>
        <a href="{{ route('admin.login') }}">Admin Login</a>
      </div>
    </div>
  </div>
</footer>

<div class="float-stack">
  <button class="float-btn float-top" id="scrollTopBtn" aria-label="Scroll to top" onclick="window.scrollTo({top:0, behavior:'smooth'})">
    <svg style="width:20px;height:20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 19V5M5 12l7-7 7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </button>
  <a class="float-btn float-whatsapp" href="https://wa.me/263776651578" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <svg style="width:24px;height:24px;" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm0 18.2a8.2 8.2 0 0 1-4.2-1.1l-.3-.2-2.9.8.8-2.8-.2-.3A8.2 8.2 0 1 1 12 20.2Z"/></svg>
  </a>
</div>

<div class="toast" id="toast"></div>

<script>
  // Scroll-to-top visibility
  window.addEventListener('scroll', () => {
    document.getElementById('scrollTopBtn').classList.toggle('visible', window.scrollY > 400);
  });

  // Newsletter subscribe
  document.getElementById('newsletterForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = this;
    const toast = document.getElementById('toast');
    const email = form.email.value;

    fetch(@json(route('newsletter.store')), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': @json(csrf_token()),
      },
      body: JSON.stringify({ email }),
    })
      .then(res => {
        toast.textContent = res.ok
          ? "You're subscribed — welcome to " + @json(config('app.name')) + "!"
          : "Something went wrong — please check that email address.";
        toast.classList.add('show');
        if (res.ok) form.reset();
        setTimeout(() => toast.classList.remove('show'), 3200);
      })
      .catch(() => {
        toast.textContent = "Something went wrong — please try again.";
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3200);
      });
  });
</script>

@yield('scripts')

</body>
</html>
