@extends('layouts.site')

@section('title', 'About — '.config('app.name'))

@section('styles')
  .about-grid{display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-top:40px;}
  @media(max-width:860px){ .about-grid{grid-template-columns:1fr;} }
  .about-card{background:var(--paper-2); border:1px solid var(--line); border-radius:14px; padding:26px;}
  .about-card .num{font-family:'Fraunces',serif; font-size:28px; font-weight:600; color:var(--forest);}
  .mission{padding:70px 0; max-width:70ch; margin:0 auto;}
@endsection

@section('content')

<section class="page-hero">
  <div class="wrap">
    <h1>Property in Zimbabwe, built on trust</h1>
    <p>{{ config('app.name') }} means "inheritance" in Shona — we believe finding a home should feel like that: something passed on honestly, not fought over through fake listings and disappearing agents.</p>
  </div>
</section>

<section class="mission">
  <div class="wrap">
    <h2 style="font-size:26px;">Why we exist</h2>
    <p style="margin-top:16px; color:rgba(19,28,43,0.75); font-size:15.5px; line-height:1.7;">
      Property hunting in Zimbabwe has long meant scrolling endless Facebook groups, chasing WhatsApp numbers that go unanswered, and sometimes paying viewing fees for houses that don't exist. {{ config('app.name') }} was built to fix that: every agent and landlord who lists here has their ID checked, and every sale listing carries a document review before it goes live.
    </p>
    <p style="margin-top:16px; color:rgba(19,28,43,0.75); font-size:15.5px; line-height:1.7;">
      Searching is, and always will be, free for house-hunters. Landlords and agents pay a small monthly fee to list — which is what funds the verification work in the first place.
    </p>

    <div class="about-grid">
      <div class="about-card">
        <div class="num">2,480+</div>
        <p style="margin-top:6px; font-size:14px; color:rgba(19,28,43,0.65);">Verified listings across the country</p>
      </div>
      <div class="about-card">
        <div class="num">640+</div>
        <p style="margin-top:6px; font-size:14px; color:rgba(19,28,43,0.65);">Registered agents and landlords</p>
      </div>
      <div class="about-card">
        <div class="num">10</div>
        <p style="margin-top:6px; font-size:14px; color:rgba(19,28,43,0.65);">Provinces covered nationwide</p>
      </div>
    </div>
  </div>
</section>

<section class="trust">
  <div class="wrap">
    <div class="trust-grid" style="grid-template-columns:1fr;">
      <div>
        <h2>Get in touch</h2>
        <p class="lede">Questions about a listing, want to report a scam, or thinking of listing your own property? Reach us directly.</p>
        <div class="trust-points">
          <div class="trust-point">
            <span class="num">✉</span>
            <p><b>Email</b>support@nhaka.co.zw</p>
          </div>
          <div class="trust-point">
            <span class="num">☎</span>
            <p><b>WhatsApp / Phone</b>+263 77 665 1578</p>
          </div>
          <div class="trust-point">
            <span class="num">⌂</span>
            <p><b>Head office</b>Harare, Zimbabwe</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
