@extends('layouts.site')

@section('styles')
  /* ---------- HERO (full-bleed rotating background) ---------- */
  .hero{position:relative; overflow:hidden; min-height:640px; display:flex; align-items:center; color:#fff;}
  .hero-bg-slide{position:absolute; inset:0; opacity:0; transition:opacity 1.4s ease; background-size:cover; background-position:center; pointer-events:none;}
  .hero-bg-slide.active{opacity:1; pointer-events:auto;}
  .hero-overlay{position:absolute; inset:0; background:linear-gradient(100deg, rgba(11,20,35,0.82) 0%, rgba(11,20,35,0.6) 45%, rgba(11,20,35,0.35) 100%); z-index:1;}
  .hero-inner{position:relative; z-index:2; padding:90px 0;}
  .hero h1{font-size:clamp(36px, 4.8vw, 58px); max-width:14ch; color:#fff;}
  .hero .lede{margin-top:22px; font-size:17.5px; max-width:48ch; color:rgba(255,255,255,0.85);}
  .province-tag{display:inline-flex; align-items:center; gap:8px; margin-bottom:18px; font-size:14px; font-weight:600; color:var(--gold-light);}
  .province-tag .dot{width:7px; height:7px; border-radius:50%; background:var(--gold);}
  .hero-dots{position:absolute; z-index:3; right:32px; bottom:28px; display:flex; gap:7px;}
  .hero-dots button{width:8px; height:8px; border-radius:50%; border:1.5px solid rgba(255,255,255,0.8); background:rgba(255,255,255,0.25); padding:0; cursor:pointer;}
  .hero-dots button.active{background:#fff;}

  .searchbar{margin-top:36px; background:var(--paper-2); border:1px solid var(--line); border-radius:12px; padding:10px; display:grid; grid-template-columns:1.3fr 1fr 1fr auto; gap:8px; box-shadow:0 20px 40px -24px rgba(0,0,0,0.5); max-width:820px;}
  .searchbar .field{padding:12px 14px; border-radius:8px;}
  .searchbar .field:hover{background:rgba(19,28,43,0.04);}
  .searchbar label{display:block; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; color:rgba(19,28,43,0.55); margin-bottom:3px;}
  .searchbar select, .searchbar input{border:none; background:none; font-family:inherit; font-size:15px; font-weight:600; color:var(--ink); width:100%;}
  .searchbar select:focus, .searchbar input:focus{outline:none;}
  .searchbar .go{background:var(--gold); color:var(--forest-dark); border:none; border-radius:8px; padding:0 26px; font-weight:700; font-size:15px; cursor:pointer;}
  .searchbar .go:hover{background:var(--gold-light);}
  @media(max-width:860px){
    .hero{min-height:auto;}
    .searchbar{grid-template-columns:1fr 1fr; grid-auto-rows:auto;}
    .searchbar .go{grid-column:1/3;}
  }

  .stats-strip{margin-top:26px; font-size:13.5px; color:rgba(255,255,255,0.75); display:flex; gap:22px; flex-wrap:wrap;}
  .stats-strip b{color:#fff;}

  .categories{padding:70px 0;}
  .cat-row{display:grid; grid-template-columns:1.3fr 1fr 1fr 1fr; gap:16px;}
  @media(max-width:860px){ .cat-row{grid-template-columns:1fr 1fr;} }
  .cat-card{border-radius:14px; padding:26px 22px; min-height:150px; display:flex; flex-direction:column; justify-content:space-between;}
  .cat-card:hover{transform:translateY(-3px);}
  .cat-card h3{font-size:21px; font-weight:600;}
  .cat-card p{font-size:13.5px; margin-top:6px; opacity:.85;}
  .cat-card .count{font-size:12.5px; font-weight:700; letter-spacing:.02em;}
  .cat-1{background:var(--forest); color:#fff; grid-row:1/3;}
  .cat-1 .count{color:var(--gold-light);}
  .cat-2{background:var(--paper-2); border:1px solid var(--line);}
  .cat-3{background:var(--gold); color:var(--forest-dark);}
  .cat-4{background:var(--paper-2); border:1px solid var(--line);}
  @media(max-width:860px){ .cat-1{grid-row:auto;} }

  .listings{padding:20px 0 80px;}

  .interiors{padding:10px 0 70px;}
  .interior-scroll{display:flex; gap:16px; overflow-x:auto; padding-bottom:8px; scroll-snap-type:x mandatory;}
  .interior-scroll::-webkit-scrollbar{height:6px;}
  .interior-scroll::-webkit-scrollbar-thumb{background:var(--line); border-radius:3px;}
  .interior-item{flex:0 0 240px; scroll-snap-align:start; border-radius:12px; overflow:hidden; position:relative; height:180px;}
  .interior-item img{width:100%; height:100%; object-fit:cover;}
  .interior-item .cap{position:absolute; left:0; right:0; bottom:0; padding:12px 14px; background:linear-gradient(0deg, rgba(11,20,35,0.85), rgba(11,20,35,0)); color:#fff; font-size:13px; font-weight:600;}
@endsection

@section('content')

<section class="hero" id="heroSection">
  @foreach ($heroSlides as $i => $slide)
    {{-- Decorative: the hero headline carries the meaning, so these stay out of the a11y tree. --}}
    <div class="hero-bg-slide {{ $i === 0 ? 'active' : '' }}" aria-hidden="true"
         style="{{ \App\View\Components\ResponsiveImg::backgroundCss($slide['url']) }}"></div>
  @endforeach
  <div class="hero-overlay"></div>
  <div class="hero-dots" id="heroDots"></div>

  <div class="wrap hero-inner">
    <div class="reveal-now">
      <div class="province-tag"><span class="dot"></span>Now covering all 10 provinces</div>
      <h1>Property in Zimbabwe, without the guesswork.</h1>
      <p class="lede">Search verified rentals, houses, stands and commercial space from Harare to Mutare — direct from landlords and registered agents, no middle-men chasing you on WhatsApp.</p>

      <form class="searchbar" action="{{ route('browse') }}" method="GET">
        <div class="field">
          <label for="location">Location</label>
          <input type="text" id="location" name="location" placeholder="e.g. Borrowdale, Harare" />
        </div>
        <div class="field">
          <label for="type">Type</label>
          <select id="type" name="category">
            <option value="">Any property type</option>
            <option value="rent">Rentals</option>
            <option value="buy">Houses for sale</option>
            <option value="land">Stand / land</option>
            <option value="commercial">Commercial</option>
          </select>
        </div>
        <div class="field">
          <label for="budget">Budget (USD)</label>
          <select id="budget" name="budget">
            <option value="">Any price</option>
            <option value="0-200">Under $200</option>
            <option value="200-600">$200 – $600</option>
            <option value="600-1500">$600 – $1,500</option>
            <option value="1500+">$1,500+</option>
          </select>
        </div>
        <button class="go" type="submit">Search</button>
      </form>

      <div class="stats-strip">
        <span><b>{{ number_format($siteStats['listings']) }}</b> verified listing{{ $siteStats['listings'] === 1 ? '' : 's' }}</span>
        <span><b>{{ $siteStats['provinces'] }}</b> province{{ $siteStats['provinces'] === 1 ? '' : 's' }} covered</span>
        <span><b>{{ $siteStats['agents'] }}</b> registered agent{{ $siteStats['agents'] === 1 ? '' : 's' }} & landlords</span>
      </div>
    </div>
  </div>
</section>

<section class="categories">
  <div class="wrap">
    <div class="cat-row">
      @foreach ($categories as $category)
      <a class="cat-card {{ $category['style'] }}" href="{{ route('browse', ['category' => $category['slug']]) }}">
        <div>
          <h3>{{ $category['title'] }}</h3>
          <p>{{ $category['desc'] }}</p>
        </div>
        <div class="count">{{ number_format($category['count']) }} listings →</div>
      </a>
      @endforeach
    </div>
  </div>
</section>

<section class="listings" id="rent">
  <div class="wrap">
    <div class="section-head">
      <div>
        <h2>Fresh on {{ config('app.name') }} this week</h2>
        <p class="sub">A mix of rentals, sales and stands — hand-picked from newly verified listings.</p>
      </div>
      <a class="btn btn-ghost" href="{{ route('browse') }}">View all listings</a>
    </div>

    <div class="listing-grid">
      @foreach ($listings as $listing)
      <a class="card" href="{{ route('listings.show', $listing->slug) }}">
        <div class="thumb">
          @if ($listing->imageUrls())
            <x-responsive-img :src="$listing->imageUrls()[0]" :alt="$listing->title"
                              sizes="(max-width: 600px) 100vw, (max-width: 900px) 50vw, 380px" :width="400" :height="200" />
          @endif
          @if ($listing->is_verified)
            <span class="badge"><span class="v"></span>Verified</span>
          @endif
          <span class="price-tag">{{ $listing->displayPrice() }}</span>
        </div>
        <div class="body">
          <h3>{{ $listing->title }}</h3>
          <p class="loc">{{ $listing->location }}</p>
          <div class="meta">
            @foreach ($listing->metaSummary() as $item)
              <span>{{ $item }}</span>
            @endforeach
          </div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>

<section class="interiors">
  <div class="wrap">
    <div class="section-head">
      <div>
        <h2>Step inside real Nhaka homes</h2>
        <p class="sub">A look at the kind of finishes and interiors landlords and agents list on Nhaka.</p>
      </div>
    </div>
    <div class="interior-scroll">
      @foreach ($interiors as $item)
        <div class="interior-item">
          <x-responsive-img :src="$item['image_url']" :alt="$item['caption']"
                         sizes="240px" :width="240" :height="180" />
          @if ($item['caption'])
            <div class="cap">{{ $item['caption'] }}</div>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="trust">
  <div class="wrap">
    <div class="trust-grid">
      <div>
        <h2>{{ $trustHeading }}</h2>
        <p class="lede">{{ $trustLede }}</p>
        <div class="trust-points">
          <div class="trust-point">
            <span class="num">01</span>
            <p><b>ID-checked agents</b>National ID and proof of address confirmed before any listing goes live.</p>
          </div>
          <div class="trust-point">
            <span class="num">02</span>
            <p><b>Title verification for sales</b>Stands and houses for sale carry a document check, not just a photo and a price.</p>
          </div>
          <div class="trust-point">
            <span class="num">03</span>
            <p><b>Report and remove</b>Any listing can be flagged by a house-hunter, and we act within 24 hours.</p>
          </div>
        </div>
      </div>
      <div class="trust-visual">
        <div class="verify-card">
          <div class="top">
            <div>
              <div class="id-line">{{ $featuredAgent ? 'Listed by' : 'What a verified profile looks like' }}</div>
              <h4>{{ $featuredAgent->name ?? 'Example agent profile' }}</h4>
            </div>
            <div class="agent"></div>
          </div>
          <span class="verify-badge">✓ ID verified · Registered {{ $featuredAgent->role ?? 'agent' }}</span>
          <div class="id-line" style="margin-top:14px;">
            @if ($featuredAgent)
              On {{ config('app.name') }} since {{ $featuredAgent->created_at->format('Y') }} · {{ $featuredAgent->properties_count }} active listing{{ $featuredAgent->properties_count === 1 ? '' : 's' }}
            @else
              Every agent goes through this same ID and address check before their first listing goes live.
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pricing" id="list">
  <div class="wrap">
    <div class="section-head">
      <div>
        <h2>List your property</h2>
        <p class="sub">Free for house-hunters, always. Landlords and agents choose a plan that fits how much they list.</p>
      </div>
    </div>
    <div class="price-grid">
      @foreach ($pricing as $plan)
      <div class="price-card {{ $plan['featured'] ? 'featured' : '' }}">
        @if ($plan['featured'])
          <span class="featured-tag">Most popular</span>
        @endif
        <div class="tier">{{ $plan['tier'] }}</div>
        <div class="amount">{{ $plan['amount'] }}@if($plan['period'])<span> {{ $plan['period'] }}</span>@endif</div>
        <p class="desc">{{ $plan['desc'] }}</p>
        <ul>
          @foreach ($plan['features'] as $feature)
            <li>{{ $feature }}</li>
          @endforeach
        </ul>
        <a class="btn" href="{{ auth()->check() ? route('subscribe.index') : route('register') }}">{{ $plan['cta'] }}</a>
      </div>
      @endforeach
    </div>
  </div>
</section>

@endsection

@section('scripts')
<script>
  // Hero background carousel
  (function () {
    const slides = document.querySelectorAll('.hero-bg-slide');
    const dotsWrap = document.getElementById('heroDots');
    let current = 0;

    slides.forEach((_, i) => {
      const dot = document.createElement('button');
      if (i === 0) dot.classList.add('active');
      dot.addEventListener('click', () => show(i));
      dotsWrap.appendChild(dot);
    });

    function show(index) {
      slides[current].classList.remove('active');
      dotsWrap.children[current].classList.remove('active');
      current = index;
      slides[current].classList.add('active');
      dotsWrap.children[current].classList.add('active');
    }

    setInterval(() => show((current + 1) % slides.length), 5000);
  })();
</script>
@endsection
