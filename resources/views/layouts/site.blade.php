<!DOCTYPE html>
<html lang="en" class="no-js">
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
@php
    // Built inside @php on purpose: Blade parses the
    // '@type' keys in this array as directives otherwise.
    $nhakaSchema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'RealEstateAgent',
            '@id' => url('/').'#organization',
            'name' => config('app.name'),
            'url' => url('/'),
            'description' => 'Verified rental and sale property listings across Zimbabwe, direct from landlords and registered agents.',
            'areaServed' => ['@type' => 'Country', 'name' => 'Zimbabwe'],
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Harare',
                'addressCountry' => 'ZW',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer support',
                'telephone' => '+263776651578',
                'email' => 'support@nhaka.co.zw',
                'areaServed' => 'ZW',
                'availableLanguage' => ['en'],
            ],
        ],
        [
            '@type' => 'WebSite',
            '@id' => url('/').'#website',
            'url' => url('/'),
            'name' => config('app.name'),
            'publisher' => ['@id' => url('/').'#organization'],
            'inLanguage' => 'en',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => route('browse').'?location={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ],
    ],
];
@endphp
<script type="application/ld+json">{!! json_encode($nhakaSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@stack('schema')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Archivo:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    /* --- brand core (unchanged identity) --- */
    --ink:#131C2B;
    --paper:#F2F5F9;
    --paper-2:#FFFFFF;
    --forest:#123A6B;
    --forest-dark:#0B2545;
    --gold:#C08A28;
    --gold-light:#DBAE5A;
    --brick:#3E6FA6;
    --line: rgba(19,28,43,0.12);

    /* --- derived semantic text (all >= 4.5:1 on paper) --- */
    --ink-soft: rgba(19,28,43,0.72);
    --ink-mute: rgba(19,28,43,0.68);
    --on-dark-soft: rgba(255,255,255,0.86);
    --on-dark-mute: rgba(255,255,255,0.72);

    /* --- surface & line --- */
    --line-strong: rgba(19,28,43,0.18);
    --tint-forest: rgba(18,58,107,0.08);
    --tint-gold: rgba(192,138,40,0.12);

    /* --- spacing scale (density 5 / standard: 16-64) --- */
    --space-1:4px;  --space-2:8px;  --space-3:16px;
    --space-4:24px; --space-5:32px; --space-6:48px; --space-7:64px;

    /* --- radius --- */
    --r-sm:8px; --r-md:12px; --r-lg:16px; --r-xl:22px; --r-pill:999px;

    /* --- elevation (layered, soft, navy-tinted) --- */
    --sh-1:0 1px 2px rgba(19,28,43,0.05), 0 2px 8px -4px rgba(19,28,43,0.10);
    --sh-2:0 2px 4px rgba(19,28,43,0.05), 0 12px 24px -12px rgba(19,28,43,0.18);
    --sh-3:0 4px 8px rgba(19,28,43,0.06), 0 24px 48px -20px rgba(19,28,43,0.28);
    --sh-gold:0 10px 26px -12px rgba(192,138,40,0.55);

    /* --- motion --- */
    --ease:cubic-bezier(0.22,0.61,0.36,1);
    --ease-out-back:cubic-bezier(0.34,1.4,0.64,1);
    --dur-1:160ms; --dur-2:240ms; --dur-3:380ms;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  /* Visible to screen readers, not on screen. */
  .sr-only{
    position:absolute; width:1px; height:1px; padding:0; margin:-1px;
    overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0;
  }
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
    transition:color var(--dur-1) var(--ease), background-color var(--dur-1) var(--ease),
               border-color var(--dur-1) var(--ease), transform var(--dur-2) var(--ease),
               box-shadow var(--dur-2) var(--ease), opacity var(--dur-2) var(--ease);
  }

  /* ---------- SKIP LINK (WCAG 2.4.1) ----------
     Off-screen until focused, so keyboard users can jump the nav. */
  .skip-link{
    position:absolute; left:50%; transform:translate(-50%,-140%);
    z-index:100; background:var(--forest-dark); color:#fff;
    padding:12px 20px; border-radius:0 0 var(--r-sm) var(--r-sm);
    font-weight:600; font-size:14px; text-decoration:none;
    transition:transform var(--dur-1) var(--ease);
  }
  .skip-link:focus{transform:translate(-50%,0);}

  /* ---------- FOCUS VISIBILITY (WCAG 2.4.7 / 2.4.11) ----------
     Two-tone ring so it stays visible on both paper and navy surfaces. */
  :focus-visible{
    outline:2px solid var(--gold);
    outline-offset:2px;
    border-radius:var(--r-sm);
  }
  .topbar :focus-visible, .page-hero :focus-visible, .trust :focus-visible,
  footer :focus-visible, .newsletter :focus-visible, .hero :focus-visible{
    outline-color:var(--gold-light);
    box-shadow:0 0 0 4px rgba(11,37,69,0.55);
  }
  /* Only suppress the ring for pointer users, never for keyboard. */
  :focus:not(:focus-visible){outline:none;}

  /* ---------- SCROLL REVEAL ----------
     Fires when the element enters the viewport (was: on page load regardless). */
  @keyframes fadeUp{ from{opacity:0; transform:translateY(14px);} to{opacity:1; transform:translateY(0);} }
  .reveal{opacity:0;}
  .reveal.in{animation:fadeUp var(--dur-3) var(--ease) both;}
  /* Above-the-fold content animates on load, not on intersection. */
  .reveal-now{opacity:0; animation:fadeUp var(--dur-3) var(--ease) both;}
  .reveal-delay-1.in{animation-delay:.08s;}
  .reveal-delay-2.in{animation-delay:.16s;}
  .reveal-delay-3.in{animation-delay:.24s;}
  /* If JS never runs, content must still be visible. */
  .no-js .reveal, html:not(.js) .reveal{opacity:1;}

  /* ---------- REDUCED MOTION (WCAG 2.3.3) ---------- */
  @media (prefers-reduced-motion: reduce){
    html{scroll-behavior:auto;}
    *, *::before, *::after{
      animation-duration:.01ms !important;
      animation-iteration-count:1 !important;
      transition-duration:.01ms !important;
      scroll-behavior:auto !important;
    }
    .reveal{opacity:1 !important; animation:none !important;}
    /* Kill lift/zoom transforms, keep colour feedback */
    .card:hover, .price-card:hover, .cat-card:hover, .btn-primary:hover{transform:none !important;}
    .card:hover .thumb img{transform:none !important;}
  }

  /* ---------- TOP BAR ---------- */
  .topbar{background:var(--forest-dark); color:rgba(255,255,255,0.85); font-size:13px;}
  .topbar .wrap{display:flex; align-items:center; justify-content:space-between; padding:9px 32px; flex-wrap:wrap; gap:8px;}
  .topbar .contacts{display:flex; align-items:center; gap:20px; flex-wrap:wrap;}
  .topbar .contacts a{display:inline-flex; align-items:center; gap:6px; color:rgba(255,255,255,0.85);}
  .topbar .contacts a:hover{color:#fff;}
  .topbar .social{display:flex; align-items:center; gap:2px;}
  .topbar .social span{color:var(--on-dark-mute); font-weight:600; letter-spacing:.02em; margin-right:8px;}
  /* 36px box + 4px bar padding = 44px effective touch target */
  .topbar .social a{
    color:rgba(255,255,255,0.85); display:inline-flex; align-items:center; justify-content:center;
    width:36px; height:36px; border-radius:var(--r-pill);
  }
  .topbar .social a:hover{color:var(--gold-light); background:rgba(255,255,255,0.10);}
  .icon{width:15px; height:15px; display:block;}

  /* ---------- HEADER ---------- */
  header{
    padding:18px 0 16px; border-bottom:1px solid var(--line); background:var(--paper-2);
    position:sticky; top:0; z-index:40;
    transition:box-shadow var(--dur-2) var(--ease), padding var(--dur-2) var(--ease);
  }
  header.stuck{box-shadow:var(--sh-2); padding:11px 0 10px;}
  header .wrap{display:flex; align-items:center; justify-content:space-between; gap:var(--space-4);}
  .logo{font-family:'Fraunces', serif; font-size:24px; font-weight:700; display:flex; align-items:center; gap:10px;}
  nav{display:flex; align-items:center; gap:30px;}
  nav .links{display:flex; gap:28px; font-size:15px; font-weight:500;}
  nav .links a{padding-bottom:4px; border-bottom:1px solid transparent;}
  nav .links a:hover, nav .links a.active{border-color:var(--ink);}
  .btn{
    display:inline-flex; align-items:center; justify-content:center; gap:8px;
    min-height:44px; padding:12px 22px; border-radius:var(--r-sm);
    font-weight:600; font-size:14.5px; cursor:pointer; border:none;
    font-family:inherit; text-align:center; white-space:nowrap;
  }
  .btn-primary{background:var(--forest); color:#fff; box-shadow:var(--sh-1);}
  .btn-primary:hover{transform:translateY(-2px); box-shadow:0 10px 22px -8px rgba(18,58,107,0.45); background:var(--forest-dark);}
  .btn-primary:active{transform:translateY(0); box-shadow:var(--sh-1);}
  .btn-ghost{border:1px solid var(--line-strong); background:transparent; color:var(--ink);}
  .btn-ghost:hover{background:var(--ink); color:#fff; border-color:var(--ink);}
  .btn-ghost:active{transform:translateY(1px);}
  /* Gold CTA - reserved for the single primary conversion action */
  .btn-gold{background:var(--gold); color:var(--forest-dark); box-shadow:var(--sh-1);}
  .btn-gold:hover{background:var(--gold-light); transform:translateY(-2px); box-shadow:var(--sh-gold);}
  .btn-gold:active{transform:translateY(0);}
  .btn-row{display:flex; align-items:center; gap:10px;}
  @media(max-width:860px){ nav .links{display:none;} }

  /* ---------- PAGE HERO (simple, non-home pages) ---------- */
  .page-hero{background:var(--forest); color:#fff; padding:60px 0 50px;}
  .page-hero h1{font-size:clamp(30px,4vw,44px);}
  .page-hero p{margin-top:14px; font-size:16px; color:rgba(255,255,255,0.82); max-width:56ch;}
  .breadcrumb{font-size:13px; color:rgba(255,255,255,0.6); margin-bottom:14px;}
  .breadcrumb a:hover{color:#fff;}

  /* ---------- CATEGORY / CARD SHARED ---------- */
  .section-head{display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:var(--space-5); gap:var(--space-4); flex-wrap:wrap;}
  .section-head h2{font-size:clamp(28px,3.4vw,38px); position:relative;}
  .section-head > div > h2::before{
    content:""; display:block; width:38px; height:3px; border-radius:2px;
    background:var(--gold); margin-bottom:14px;
  }
  .section-head .sub{color:var(--ink-soft); font-size:15px; margin-top:8px; max-width:56ch;}

  .listing-grid{display:grid; grid-template-columns:repeat(3, 1fr); gap:var(--space-4);}
  @media(max-width:900px){ .listing-grid{grid-template-columns:1fr 1fr;} }
  @media(max-width:600px){ .listing-grid{grid-template-columns:1fr;} }

  .card{
    background:var(--paper-2); border:1px solid var(--line); border-radius:var(--r-lg);
    overflow:hidden; display:block; box-shadow:var(--sh-1); position:relative;
  }
  .card:hover{transform:translateY(-4px); box-shadow:var(--sh-3); border-color:var(--line-strong);}
  .card .thumb{
    height:200px; position:relative; overflow:hidden;
    background:linear-gradient(150deg, var(--forest), #4a6b58);
  }
  .card .thumb img{width:100%; height:100%; object-fit:cover; transition:transform var(--dur-3) var(--ease);}
  .card:hover .thumb img{transform:scale(1.06);}
  /* Scrim: guarantees the price tag stays legible over any photo */
  .card .thumb::after{
    content:""; position:absolute; inset:0; pointer-events:none;
    background:linear-gradient(0deg, rgba(11,20,35,0.62) 0%, rgba(11,20,35,0.12) 32%, rgba(11,20,35,0) 58%);
  }
  @media(max-width:600px){ .card .thumb{height:220px;} }
  .card:nth-child(2) .thumb{background:linear-gradient(150deg,var(--brick),#7fa3cc);}
  .card:nth-child(3) .thumb{background:linear-gradient(150deg,var(--gold),var(--gold-light));}
  .card:nth-child(4) .thumb{background:linear-gradient(150deg,#2c5a92,var(--forest));}
  .card:nth-child(5) .thumb{background:linear-gradient(150deg,#7fa3cc,var(--brick));}
  .card:nth-child(6) .thumb{background:linear-gradient(150deg,var(--gold-light),var(--gold));}
  .badge{
    position:absolute; top:12px; left:12px; z-index:2;
    background:rgba(255,255,255,0.96); color:var(--forest);
    font-size:11.5px; font-weight:700; letter-spacing:.02em;
    padding:6px 11px; border-radius:var(--r-pill);
    display:inline-flex; align-items:center; gap:5px; box-shadow:var(--sh-1);
  }
  .badge .v{width:6px; height:6px; border-radius:50%; background:var(--gold); flex-shrink:0;}
  .price-tag{
    position:absolute; bottom:12px; left:12px; z-index:2;
    color:#fff; font-family:'Fraunces',serif; font-weight:600; font-size:19px;
    letter-spacing:-0.01em; text-shadow:0 1px 8px rgba(11,20,35,0.5);
  }
  .card .body{padding:var(--space-3) var(--space-3) 18px;}
  .card h3{
    font-size:17px; font-weight:600; font-family:'Archivo',sans-serif; line-height:1.35;
    /* keep titles to two lines so every card in a row stays the same height */
    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
  }
  .card .loc{font-size:13.5px; color:var(--ink-mute); margin-top:5px; display:flex; align-items:center; gap:5px;}
  .card .meta{margin-top:14px; padding-top:14px; border-top:1px solid var(--line); display:flex; gap:16px; font-size:13px; color:var(--ink-soft);}

  .filter-row{display:flex; gap:10px; flex-wrap:wrap; margin-bottom:30px;}
  .filter-chip{
    display:inline-flex; align-items:center; min-height:44px;
    padding:9px 18px; border-radius:var(--r-pill); border:1px solid var(--line);
    background:var(--paper-2); font-size:13.5px; font-weight:600; cursor:pointer;
    font-family:inherit; color:var(--ink);
  }
  .filter-chip:hover{border-color:var(--forest); color:var(--forest); background:var(--tint-forest);}
  .filter-chip.active{background:var(--forest); color:#fff; border-color:var(--forest); box-shadow:var(--sh-1);}

  /* ---------- PAGINATION ---------- */
  .pagination{display:flex; align-items:center; justify-content:center; gap:6px; margin-top:40px; flex-wrap:wrap;}
  .pagination a, .pagination span{display:inline-flex; align-items:center; justify-content:center; min-width:44px; height:44px; padding:0 12px; border-radius:var(--r-sm); border:1px solid var(--line); background:var(--paper-2); font-size:13.5px; font-weight:600; color:var(--ink);}
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
  .newsletter-form input:focus-visible{outline:2px solid var(--gold-light); outline-offset:-2px; z-index:1; position:relative;}
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
<script>
  /* Runs before first paint: only hide .reveal elements once we know JS can show them again. */
  document.documentElement.classList.remove('no-js');
  document.documentElement.classList.add('js');
</script>
</head>
<body>

<a class="skip-link" href="#main">Skip to main content</a>

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

<span id="headerSentinel" aria-hidden="true" style="position:absolute; top:0; height:1px; width:1px;"></span>

<header id="siteHeader">
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
          <a class="btn btn-gold" href="{{ route('register') }}">Get Started</a>
        @endauth
      </div>
    </nav>
  </div>
</header>

<main id="main">
@yield('content')
</main>

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
      <label for="newsletterEmail" class="sr-only">Your email address</label>
      <input type="email" id="newsletterEmail" name="email" placeholder="Your email address" required>
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
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

  // Scroll-to-top visibility (passive: never blocks scrolling)
  window.addEventListener('scroll', () => {
    document.getElementById('scrollTopBtn').classList.toggle('visible', window.scrollY > 400);
  }, { passive: true });

  // Sticky header elevation, via sentinel rather than a per-frame scroll handler
  (function () {
    const sentinel = document.getElementById('headerSentinel');
    const header = document.getElementById('siteHeader');
    if (!sentinel || !header || !('IntersectionObserver' in window)) return;
    new IntersectionObserver(
      ([entry]) => header.classList.toggle('stuck', !entry.isIntersecting),
      { threshold: 0 }
    ).observe(sentinel);
  })();

  // Scroll reveal — only animate what actually enters the viewport
  (function () {
    const items = document.querySelectorAll('.reveal');
    if (!items.length) return;

    // No observer support, or the visitor asked for less motion: show everything now.
    if (!('IntersectionObserver' in window) || reduceMotion.matches) {
      items.forEach(el => el.classList.add('in'));
      return;
    }
    const io = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in');
          io.unobserve(entry.target); // reveal once, then stop watching
        }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    items.forEach(el => io.observe(el));
  })();

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
