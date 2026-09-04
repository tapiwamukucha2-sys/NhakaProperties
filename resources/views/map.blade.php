@extends('layouts.site')

@section('title', 'Map View — '.config('app.name'))

@section('styles')
  .province-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:16px;}
  @media(max-width:900px){ .province-grid{grid-template-columns:repeat(2,1fr);} }
  @media(max-width:600px){ .province-grid{grid-template-columns:1fr;} }
  .province-card{background:var(--paper-2); border:1px solid var(--line); border-radius:14px; padding:22px; display:block;}
  .province-card:hover{transform:translateY(-3px); box-shadow:0 16px 30px -20px rgba(19,28,43,0.4);}
  .province-card .count{font-family:'Fraunces',serif; font-size:26px; font-weight:600; color:var(--forest);}
  .province-card h3{font-size:16px; margin-top:6px;}
  .province-card p{font-size:13px; color:rgba(19,28,43,0.6); margin-top:6px;}
  .map-placeholder{height:360px; border-radius:16px; background:linear-gradient(135deg,#dbe4ee,#c3d2e3); display:flex; align-items:center; justify-content:center; color:rgba(19,28,43,0.5); font-weight:600; margin-bottom:40px; border:1px solid var(--line);}
@endsection

@section('content')

<section class="page-hero">
  <div class="wrap">
    <h1>Map view</h1>
    <p>Explore where Nhaka listings are concentrated across Zimbabwe's provinces. Full interactive pin-drop map is coming soon — for now, browse by province.</p>
  </div>
</section>

<section style="padding:50px 0 80px;">
  <div class="wrap">
    <div class="map-placeholder">Interactive map coming soon</div>

    <div class="section-head">
      <div>
        <h2>Browse by province</h2>
        <p class="sub">Tap a province to see listings in that area.</p>
      </div>
    </div>

    <div class="province-grid">
      @foreach ($provinces as $province)
        <a class="province-card" href="{{ route('browse', ['location' => $province['name']]) }}">
          <div class="count">{{ number_format($province['count']) }}</div>
          <h3>{{ $province['name'] }}</h3>
          <p>{{ $province['blurb'] }}</p>
        </a>
      @endforeach
    </div>
  </div>
</section>

@endsection
