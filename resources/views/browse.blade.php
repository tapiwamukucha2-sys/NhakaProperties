@extends('layouts.site')

@section('title', 'Browse Listings — '.config('app.name'))

@section('content')

<section class="page-hero">
  <div class="wrap">
    <h1>Browse listings</h1>
    <p>Every rental, sale, stand and commercial space currently live on {{ config('app.name') }}.</p>
  </div>
</section>

<section style="padding:50px 0 80px;">
  <div class="wrap">
    <form method="GET" style="margin-bottom:24px; max-width:420px;">
      <input type="text" name="location" value="{{ $location }}" placeholder="Search by location or title..."
             style="width:100%; padding:13px 16px; border:1px solid var(--line); border-radius:8px; font-family:inherit; font-size:14.5px;">
    </form>

    <div class="filter-row">
      <a href="{{ route('browse', array_filter(['location' => $location])) }}" class="filter-chip {{ !$activeCategory ? 'active' : '' }}">All</a>
      @foreach ($categories as $value => $label)
        <a href="{{ route('browse', array_filter(['category' => $value, 'location' => $location])) }}"
           class="filter-chip {{ $activeCategory === $value ? 'active' : '' }}">{{ $label }}</a>
      @endforeach
    </div>

    @if ($listings->isEmpty())
      <div style="padding:60px 0; text-align:center; color:rgba(19,28,43,0.55);">
        No listings match that search yet. Try a different location or category.
      </div>
    @else
      <div class="listing-grid">
        @foreach ($listings as $listing)
        <a class="card" href="{{ route('listings.show', $listing->slug) }}">
          <div class="thumb">
            @if ($listing->imageUrls())
              <img src="{{ $listing->imageUrls()[0] }}" alt="{{ $listing->title }}">
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
    @endif
  </div>
</section>

@endsection
