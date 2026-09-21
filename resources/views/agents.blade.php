@extends('layouts.site')

@section('title', 'Agents & Landlords — '.config('app.name'))

@section('styles')
  .agent-grid{display:grid; grid-template-columns:repeat(3,1fr); gap:20px;}
  @media(max-width:900px){ .agent-grid{grid-template-columns:1fr 1fr;} }
  @media(max-width:600px){ .agent-grid{grid-template-columns:1fr;} }
  .agent-card{background:var(--paper-2); border:1px solid var(--line); border-radius:14px; padding:24px;}
  .agent-card .top{display:flex; align-items:center; gap:14px;}
  .agent-card .avatar{width:50px; height:50px; border-radius:50%; background:var(--gold); flex-shrink:0;}
  .agent-card h3{font-size:16.5px;}
  .agent-card .role{font-size:12.5px; color:rgba(19,28,43,0.55); margin-top:2px;}
  .agent-card .stats{display:flex; gap:18px; margin-top:18px; padding-top:16px; border-top:1px solid var(--line); font-size:13px; color:rgba(19,28,43,0.65);}
  .agent-card .stats b{display:block; color:var(--ink); font-size:16px;}
  .cta-band{background:var(--forest); color:#fff; padding:50px 0; text-align:center; margin-top:60px; border-radius:16px;}
@endsection

@section('content')

<section class="page-hero">
  <div class="wrap">
    <h1>Agents & landlords</h1>
    <p>Every agent on {{ config('app.name') }} has their national ID and proof of address verified before their listings go live.</p>
  </div>
</section>

<section style="padding:50px 0 80px;">
  <div class="wrap">
    <div class="agent-grid">
      @forelse ($agents as $agent)
        <div class="agent-card">
          <div class="top">
            <img src="{{ $agent->avatarUrl() }}" alt="{{ $agent->name }}" class="avatar"
                 width="88" height="88" loading="lazy" decoding="async" style="object-fit:cover;">
            <div>
              <h3>{{ $agent->name }}</h3>
              <div class="role">{{ ucfirst($agent->role) }}</div>
            </div>
          </div>
          @if ($agent->is_verified)
            <span class="verify-badge">✓ ID verified</span>
          @endif
          <div class="stats">
            <div><b>{{ $agent->properties_count }}</b>Listings</div>
            <div><b>{{ $agent->created_at->format('Y') }}</b>Since</div>
          </div>
        </div>
      @empty
        <p style="color:rgba(19,28,43,0.6);">No agents with live listings yet.</p>
      @endforelse
    </div>

    <div class="cta-band">
      <h2 style="max-width:20ch; margin:0 auto;">Are you an agent or landlord?</h2>
      <p style="margin-top:12px; color:rgba(255,255,255,0.8);">List your properties and reach thousands of verified house-hunters across Zimbabwe.</p>
      <a href="{{ route('register') }}" class="btn" style="margin-top:22px; background:var(--gold); color:var(--forest-dark); display:inline-block;">Get started free</a>
    </div>
  </div>
</section>

@endsection
