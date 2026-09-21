@extends('layouts.site')

@section('title', $property->title.' — '.$property->location.' | '.config('app.name'))
@section('description', Str::limit($property->description ?: ($property->title.' in '.$property->location.'. '.$property->displayPrice().'.'), 155))
@section('image', $property->imageUrls()[0] ?? asset('images/hero/estate-day.jpg'))

@section('styles')
  .content{padding:20px 0 80px; display:grid; grid-template-columns:1.7fr 1fr; gap:36px; align-items:start;}
  @media(max-width:900px){ .content{grid-template-columns:1fr;} }

  .gallery-main{border-radius:14px; overflow:hidden; height:420px; position:relative;}
  .gallery-main img{width:100%; height:100%; object-fit:cover;}
  .gallery-badge{position:absolute; top:16px; left:16px; background:var(--gold); color:var(--forest-dark); font-size:12px; font-weight:700; padding:6px 12px; border-radius:20px;}
  .gallery-thumbs{display:flex; gap:10px; margin-top:10px;}
  .gallery-thumbs .thumb-btn{
    padding:0; background:none; border:2px solid transparent; border-radius:8px;
    cursor:pointer; line-height:0; overflow:hidden; flex-shrink:0;
  }
  .gallery-thumbs .thumb-btn img{width:88px; height:66px; object-fit:cover; display:block;}
  .gallery-thumbs .thumb-btn:hover{border-color:var(--line-strong);}
  .gallery-thumbs .thumb-btn.active{border-color:var(--forest);}

  .title-block{margin-top:26px;}
  .title-block .cat{display:inline-block; background:var(--forest); color:#fff; font-size:12px; font-weight:700; padding:4px 12px; border-radius:20px; margin-bottom:12px; text-transform:capitalize;}
  .title-block h1{font-size:clamp(24px,3vw,32px); max-width:26ch;}
  .title-block .loc{margin-top:10px; font-size:14.5px; color:rgba(19,28,43,0.65); display:flex; align-items:center; gap:6px;}

  .section{margin-top:34px; padding-top:30px; border-top:1px solid var(--line);}
  .section h3{font-size:19px; margin-bottom:14px;}
  .section p{font-size:15px; color:rgba(19,28,43,0.75); max-width:60ch;}

  .stats-grid{display:grid; grid-template-columns:repeat(3,1fr); gap:14px;}
  @media(max-width:600px){ .stats-grid{grid-template-columns:1fr 1fr;} }
  .stat-box{background:var(--paper-2); border:1px solid var(--line); border-radius:10px; padding:16px;}
  .stat-box .v{font-size:15.5px; font-weight:700;}

  .map-box{height:220px; border-radius:12px; background:linear-gradient(135deg,#dbe4ee,#c3d2e3); display:flex; align-items:center; justify-content:center; color:rgba(19,28,43,0.45); font-size:13.5px; font-weight:600; border:1px solid var(--line);}

  .sidebar{position:sticky; top:24px; display:flex; flex-direction:column; gap:18px;}
  .price-card{background:var(--paper-2); border:1px solid var(--line); border-radius:14px; padding:24px; box-shadow:0 20px 40px -30px rgba(19,28,43,0.4);}
  .price-card .price{font-family:'Fraunces', serif; font-size:28px; font-weight:600;}
  .price-card .stack{display:flex; flex-direction:column; gap:10px; margin-top:18px;}
  .price-card .stack .btn{width:100%; text-align:center;}
  .price-card .stats-row{display:flex; justify-content:space-between; margin-top:18px; padding-top:16px; border-top:1px solid var(--line); font-size:12.5px; color:rgba(19,28,43,0.55); text-align:center;}
  .price-card .stats-row b{display:block; color:var(--ink); font-size:15px;}
  .btn-whatsapp{background:#25D366; color:#fff;}
  .btn-whatsapp:hover{background:#1ebc59;}

  .agent-card{background:var(--paper-2); border:1px solid var(--line); border-radius:14px; padding:22px;}
  .agent-card .top{display:flex; align-items:center; gap:12px;}
  .agent-card .avatar{width:44px; height:44px; border-radius:50%; background:var(--gold);}
  .agent-card h4{font-size:15.5px; font-weight:700;}
  .agent-card .role{font-size:12.5px; color:rgba(19,28,43,0.55);}
  .agent-card .meta-line{margin-top:14px; font-size:13px; color:rgba(19,28,43,0.6); display:flex; flex-direction:column; gap:6px;}

  .share-card{background:var(--paper-2); border:1px solid var(--line); border-radius:14px; padding:20px;}
  .share-card h5{font-size:12.5px; text-transform:uppercase; letter-spacing:.04em; color:rgba(19,28,43,0.5); margin-bottom:12px;}
  .share-row{display:flex; gap:10px;}
  .share-row a{width:38px; height:38px; border-radius:50%; background:var(--paper); display:flex; align-items:center; justify-content:center; border:1px solid var(--line);}
  .share-row a:hover{background:var(--forest); color:#fff; border-color:var(--forest);}
@endsection

@section('content')

<div class="wrap breadcrumb" style="padding-top:20px; color:var(--ink); opacity:.6;">
  <a href="{{ route('home') }}">Home</a> / <a href="{{ route('browse') }}">Browse</a> / <span>{{ $property->title }}</span>
</div>

@php $gallery = $property->imageUrls(); @endphp

<div class="wrap content">
  <div>
    <div class="gallery-main" id="galleryMain">
      @if ($property->is_verified)
        <span class="gallery-badge">✓ Verified</span>
      @endif
      @if ($gallery)
        <img src="{{ $gallery[0] }}" alt="{{ $property->title }}" id="galleryMainImg"
             width="900" height="420" decoding="async" fetchpriority="high">
      @endif
    </div>
    @if (count($gallery) > 1)
      <div class="gallery-thumbs">
        @foreach ($gallery as $i => $img)
          <button type="button" class="thumb-btn {{ $i === 0 ? 'active' : '' }}"
                  aria-label="Show photo {{ $i + 1 }} of {{ count($gallery) }}"
                  @if ($i === 0) aria-current="true" @endif
                  data-full="{{ $img }}">
            <img src="{{ $img }}" alt="" width="88" height="66" loading="lazy" decoding="async">
          </button>
        @endforeach
      </div>
    @endif

    <div class="title-block">
      <span class="cat">{{ $property->category }}</span>
      <h1>{{ $property->title }}</h1>
      <div class="loc">
        <svg style="width:15px;height:15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-6.3 7-11.5A7 7 0 0 0 5 9.5C5 14.7 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.4"/></svg>
        {{ $property->location }}
      </div>
    </div>

    <div class="section">
      <h3>Property details</h3>
      <div class="stats-grid">
        @foreach ($property->metaSummary() as $item)
          <div class="stat-box"><div class="v">{{ $item }}</div></div>
        @endforeach
      </div>
    </div>

    @if ($property->description)
      <div class="section">
        <h3>About this property</h3>
        <p>{{ $property->description }}</p>
      </div>
    @endif

    <div class="section">
      <h3>Location</h3>
      <p style="margin-bottom:14px;">{{ $property->location }}, {{ $property->province }}, Zimbabwe</p>
      <div class="map-box">Map preview — exact pin shown after enquiry</div>
    </div>
  </div>

  <div class="sidebar">
    @php
      $agentPhone = preg_replace('/[^0-9]/', '', $property->user->phone ?? '');
      if ($agentPhone !== '' && $agentPhone[0] === '0') {
          $agentPhone = '263'.substr($agentPhone, 1);
      }
      $whatsappMessage = urlencode('Hi, I\'m interested in '.$property->title.' on '.config('app.name').'.');
    @endphp
    <div class="price-card">
      <div class="price">{{ $property->displayPrice() }}</div>
      <div class="stack">
        @if ($agentPhone !== '')
          @auth
            <a href="https://wa.me/{{ $agentPhone }}?text={{ $whatsappMessage }}" target="_blank" rel="noopener" class="btn btn-whatsapp">WhatsApp {{ ucfirst($property->user->role) }}</a>
          @else
            <a href="{{ route('login') }}" class="btn btn-primary">Login to Enquire</a>
            <a href="https://wa.me/{{ $agentPhone }}?text={{ $whatsappMessage }}" target="_blank" rel="noopener" class="btn btn-whatsapp">WhatsApp {{ ucfirst($property->user->role) }}</a>
          @endauth
        @else
          @auth
            <a href="mailto:{{ $property->user->email }}?subject={{ urlencode('Enquiry about '.$property->title) }}" class="btn btn-whatsapp">Email {{ ucfirst($property->user->role) }}</a>
          @else
            <a href="{{ route('login') }}" class="btn btn-primary">Login to Enquire</a>
            <a href="mailto:{{ $property->user->email }}?subject={{ urlencode('Enquiry about '.$property->title) }}" class="btn btn-whatsapp">Email {{ ucfirst($property->user->role) }}</a>
          @endauth
        @endif
      </div>
      <div class="stats-row">
        <div><b>{{ $property->created_at->diffForHumans() }}</b>Listed</div>
        <div><b>{{ $property->is_verified ? 'Yes' : 'Pending' }}</b>Verified</div>
        <div><b>{{ ucfirst($property->status) }}</b>Status</div>
      </div>
    </div>

    <div class="agent-card">
      <div class="top">
        <img src="{{ $property->user->avatarUrl() }}" alt="{{ $property->user->name }}" class="avatar"
             width="56" height="56" loading="lazy" decoding="async" style="object-fit:cover;">
        <div>
          <h4>{{ $property->user->name }}</h4>
          <div class="role">{{ ucfirst($property->user->role) }}</div>
        </div>
      </div>
      @if ($property->user->is_verified)
        <span class="verify-badge">✓ ID verified</span>
      @endif
      <div class="meta-line">
        <span>On {{ config('app.name') }} since {{ $property->user->created_at->format('Y') }}</span>
        <span>{{ $property->user->properties()->published()->count() }} active listings</span>
      </div>
    </div>

    <div class="share-card">
      <h5>Share this property</h5>
      <div class="share-row">
        <a href="https://wa.me/?text={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
          <svg style="width:17px;height:17px;" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Z"/></svg>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" aria-label="Share on Facebook">
          <svg style="width:17px;height:17px;" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.8h2.6l.4-3H13.5V8.3c0-.9.2-1.5 1.5-1.5h1.6V4.1C16.3 4 15.3 4 14.2 4c-2.4 0-4 1.5-4 4.1v2.1H7.6v3h2.6V21h3.3Z"/></svg>
        </a>
        <button type="button" onclick="navigator.clipboard.writeText(window.location.href); const t=document.getElementById('toast'); t.textContent='Link copied!'; t.classList.add('show'); setTimeout(() => t.classList.remove('show'), 2200);" aria-label="Copy link"
                style="width:44px; height:44px; border-radius:50%; background:var(--paper); display:flex; align-items:center; justify-content:center; border:1px solid var(--line); cursor:pointer;">
          <svg style="width:16px;height:16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.5.5l2-2a5 5 0 0 0-7-7l-1.5 1.5" stroke-linecap="round"/><path d="M14 11a5 5 0 0 0-7.5-.5l-2 2a5 5 0 0 0 7 7l1.5-1.5" stroke-linecap="round"/></svg>
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  (function () {
    const main = document.getElementById('galleryMainImg');
    const thumbs = document.querySelectorAll('.gallery-thumbs .thumb-btn');
    if (!main || !thumbs.length) return;

    thumbs.forEach(btn => {
      btn.addEventListener('click', () => {
        main.src = btn.dataset.full;
        thumbs.forEach(other => {
          other.classList.remove('active');
          other.removeAttribute('aria-current');
        });
        btn.classList.add('active');
        btn.setAttribute('aria-current', 'true');
      });
    });
  })();
</script>
@endsection
