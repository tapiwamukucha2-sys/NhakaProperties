@extends('layouts.site')

@section('title', $title.' — '.config('app.name'))

@section('styles')
  .legal-wrap{max-width:72ch; margin:0 auto; padding:60px 0 90px;}
  .legal-wrap h2{font-size:20px; margin-top:36px; margin-bottom:12px;}
  .legal-wrap h2:first-child{margin-top:0;}
  .legal-wrap p{font-size:15px; line-height:1.75; color:rgba(19,28,43,0.78); margin-bottom:14px;}
  .legal-wrap ul{margin:0 0 14px 20px;}
  .legal-wrap li{font-size:15px; line-height:1.75; color:rgba(19,28,43,0.78); margin-bottom:6px;}
  .legal-updated{font-size:13px; color:rgba(19,28,43,0.5); margin-bottom:30px;}
  .legal-tabs{display:flex; gap:10px; margin-bottom:10px;}
  .legal-tabs a{padding:8px 16px; border-radius:20px; border:1px solid var(--line); font-size:13.5px; font-weight:600;}
  .legal-tabs a.active{background:var(--forest); color:#fff; border-color:var(--forest);}
@endsection

@section('content')

<section class="page-hero">
  <div class="wrap">
    <h1>{{ $title }}</h1>
    <p>Plain-language terms for using {{ config('app.name') }}.</p>
  </div>
</section>

<div class="wrap legal-wrap">
  <div class="legal-tabs">
    <a href="{{ route('terms') }}" class="{{ $section === 'terms' ? 'active' : '' }}">Terms</a>
    <a href="{{ route('privacy') }}" class="{{ $section === 'privacy' ? 'active' : '' }}">Privacy</a>
    <a href="{{ route('cookies') }}" class="{{ $section === 'cookies' ? 'active' : '' }}">Cookies</a>
  </div>
  <p class="legal-updated">Last updated {{ now()->format('j F Y') }}</p>

  @if ($section === 'terms')
    <h2>What {{ config('app.name') }} is</h2>
    <p>{{ config('app.name') }} is a property discovery platform for Zimbabwe. We help house-hunters find rentals, sales, land and commercial space, and connect them directly with landlords and agents. We are not a real estate agency, and we are not a party to any lease or sale.</p>

    <h2>We don't collect money on your behalf</h2>
    <p>{{ config('app.name') }} does not collect rent, deposits, sale proceeds, or viewing fees. Any payment for a property is a private arrangement between you and the landlord, agent, or seller. Always verify a property in person and agree terms directly with them before paying anything.</p>

    <h2>Listing accounts</h2>
    <ul>
      <li>Landlords and agents are responsible for the accuracy of their own listings.</li>
      <li>We reserve the right to remove any listing that is fraudulent, duplicated, or violates these terms, with or without notice.</li>
      <li>A "Verified" badge means we checked the lister's ID and, for sale listings, ownership or title documents at the time of listing — it is not a guarantee against fraud.</li>
    </ul>

    <h2>Subscriptions</h2>
    <p>Landlord and agent listing plans are billed as described on the pricing page at the time of purchase. Renters and house-hunters never pay to search or browse.</p>

    <h2>Limitation of liability</h2>
    <p>{{ config('app.name') }} is provided "as is." We do our best to verify listings, but we cannot guarantee every listing is accurate, available, or free of misrepresentation. Report anything suspicious and we'll act on it within 24 hours.</p>

  @elseif ($section === 'privacy')
    <h2>What we collect</h2>
    <ul>
      <li>Account details: name, email, phone number, and role (renter, landlord, or agent) when you register.</li>
      <li>Listing content: property details, descriptions, and photos you upload.</li>
      <li>Basic usage data (pages visited, searches made) to improve the site.</li>
    </ul>

    <h2>What we don't do</h2>
    <p>We don't sell your personal information to third parties. We don't share your phone number or email with other users without your action (for example, clicking "WhatsApp Agent" opens a chat you initiate).</p>

    <h2>How we use it</h2>
    <ul>
      <li>To show your listings to house-hunters searching the site.</li>
      <li>To verify agent and landlord identities before publishing listings.</li>
      <li>To send you account-related notifications (listing approved, password reset, etc.).</li>
    </ul>

    <h2>Your data, your control</h2>
    <p>You can update or delete your account from your profile settings at any time. If you want your data removed entirely, contact <a href="mailto:support@nhaka.co.zw" style="text-decoration:underline;">support@nhaka.co.zw</a>.</p>

  @else
    <h2>What cookies we use</h2>
    <p>{{ config('app.name') }} uses a small number of essential cookies required to keep you logged in and to protect the site from cross-site request forgery. We do not currently use third-party advertising or tracking cookies.</p>

    <h2>Session cookie</h2>
    <p>A session cookie keeps you signed in as you browse. It's deleted when your session expires or you log out.</p>

    <h2>Your choices</h2>
    <p>Because our cookies are essential to signing in and browsing securely, disabling them will prevent core features (like saving a listing or accessing your dashboard) from working. Most browsers let you clear cookies manually at any time.</p>
  @endif
</div>

@endsection
