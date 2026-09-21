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
    <form method="GET" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:24px;">
      @if ($activeCategory)
        <input type="hidden" name="category" value="{{ $activeCategory }}">
      @endif
      <input type="text" name="location" value="{{ $location }}" placeholder="Search by location or title..."
             style="flex:1; min-width:220px; padding:13px 16px; border:1px solid var(--line); border-radius:8px; font-family:inherit; font-size:14.5px;">
      <select name="budget" onchange="this.form.submit()"
              style="padding:13px 16px; border:1px solid var(--line); border-radius:8px; font-family:inherit; font-size:14.5px;">
        <option value="">Any price</option>
        <option value="0-200" @selected($budget === '0-200')>Under $200</option>
        <option value="200-600" @selected($budget === '200-600')>$200 – $600</option>
        <option value="600-1500" @selected($budget === '600-1500')>$600 – $1,500</option>
        <option value="1500+" @selected($budget === '1500+')>$1,500+</option>
      </select>
      <select name="bedrooms" onchange="this.form.submit()"
              style="padding:13px 16px; border:1px solid var(--line); border-radius:8px; font-family:inherit; font-size:14.5px;">
        <option value="">Any bedrooms</option>
        <option value="1" @selected($bedrooms == '1')>1+ bed</option>
        <option value="2" @selected($bedrooms == '2')>2+ beds</option>
        <option value="3" @selected($bedrooms == '3')>3+ beds</option>
        <option value="4" @selected($bedrooms == '4')>4+ beds</option>
      </select>
      <select name="sort" onchange="this.form.submit()"
              style="padding:13px 16px; border:1px solid var(--line); border-radius:8px; font-family:inherit; font-size:14.5px;">
        <option value="newest" @selected($sort === 'newest')>Newest first</option>
        <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
        <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
      </select>
      <button type="submit" class="btn btn-primary">Search</button>
    </form>

    @php $preserved = ['location' => $location, 'budget' => $budget, 'bedrooms' => $bedrooms, 'sort' => $sort]; @endphp
    <div class="filter-row">
      <a href="{{ route('browse', array_filter($preserved)) }}" class="filter-chip {{ !$activeCategory ? 'active' : '' }}">All</a>
      @foreach ($categories as $value => $label)
        <a href="{{ route('browse', array_filter(array_merge($preserved, ['category' => $value]))) }}"
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

      {{ $listings->links('vendor.pagination.nhaka') }}
    @endif
  </div>
</section>

@endsection
