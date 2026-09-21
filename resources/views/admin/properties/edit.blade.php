@extends('layouts.admin')

@section('page-title', 'Edit property')

@section('styles')
  .form-panel{background:var(--paper-2); border:1px solid var(--line); border-radius:12px; padding:28px; max-width:760px;}
  .form-panel label{display:block; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.03em; color:rgba(19,28,43,0.55); margin-bottom:6px;}
  .form-panel input[type=text], .form-panel input[type=number], .form-panel select, .form-panel textarea{
    width:100%; padding:11px 13px; border:1px solid var(--line); border-radius:7px; font-family:inherit; font-size:14px; margin-bottom:20px;
  }
  .form-panel textarea{resize:vertical; min-height:90px;}
  .form-panel .row2{display:grid; grid-template-columns:1fr 1fr; gap:16px;}
  .form-panel .row3{display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;}
  .form-panel .hint{font-size:12.5px; color:rgba(19,28,43,0.5); margin-bottom:10px; margin-top:-14px;}
  .error-text{color:#dc2626; font-size:12.5px; margin-top:-14px; margin-bottom:14px;}
  .img-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin-bottom:16px;}
  .img-grid label{position:relative; display:block; border-radius:8px; overflow:hidden; border:1px solid var(--line); cursor:pointer;}
  .img-grid img{width:100%; height:80px; object-fit:cover; display:block;}
  .img-grid .remove-overlay{position:absolute; inset:0; background:rgba(0,0,0,0); display:flex; align-items:center; justify-content:center; color:#fff; font-size:11px; font-weight:700;}
  .img-grid input[type=checkbox]:checked ~ .remove-overlay{background:rgba(220,38,38,0.75);}
  .checkbox-row{display:flex; align-items:center; gap:8px; margin-bottom:20px; font-size:13.5px;}
@endsection

@section('content')

<div class="form-panel">
  <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="title">Title</label>
    <input id="title" name="title" type="text" value="{{ old('title', $property->title) }}" required>
    @error('title') <div class="error-text">{{ $message }}</div> @enderror

    <label for="description">Description</label>
    <textarea id="description" name="description">{{ old('description', $property->description) }}</textarea>

    <div class="row3">
      <div>
        <label for="category">Category</label>
        <select id="category" name="category">
          @foreach (['rent' => 'Rent', 'buy' => 'Buy', 'land' => 'Land / stand', 'commercial' => 'Commercial'] as $value => $label)
            <option value="{{ $value }}" @selected(old('category', $property->category) === $value)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label for="price">Price (USD)</label>
        <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $property->price) }}" required>
      </div>
      <div>
        <label for="price_period">Pricing</label>
        <select id="price_period" name="price_period">
          <option value="month" @selected(old('price_period', $property->price_period) === 'month')>Per month</option>
          <option value="once" @selected(old('price_period', $property->price_period) === 'once')>One-time</option>
        </select>
      </div>
    </div>

    <div class="row2">
      <div>
        <label for="province">Province</label>
        <input id="province" name="province" type="text" value="{{ old('province', $property->province) }}" required>
      </div>
      <div>
        <label for="location">Suburb / area</label>
        <input id="location" name="location" type="text" value="{{ old('location', $property->location) }}" required>
      </div>
    </div>

    <div class="row3">
      <div>
        <label for="bedrooms">Bedrooms</label>
        <input id="bedrooms" name="bedrooms" type="number" min="0" value="{{ old('bedrooms', $property->bedrooms) }}">
      </div>
      <div>
        <label for="bathrooms">Bathrooms</label>
        <input id="bathrooms" name="bathrooms" type="number" min="0" value="{{ old('bathrooms', $property->bathrooms) }}">
      </div>
      <div>
        <label for="size_sqm">Size (m²)</label>
        <input id="size_sqm" name="size_sqm" type="number" min="0" value="{{ old('size_sqm', $property->size_sqm) }}">
      </div>
    </div>

    <div class="row2">
      <div>
        <label for="status">Status</label>
        <select id="status" name="status">
          @foreach (['draft' => 'Draft', 'pending' => 'Pending', 'published' => 'Published', 'rejected' => 'Rejected'] as $value => $label)
            <option value="{{ $value }}" @selected(old('status', $property->status) === $value)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>&nbsp;</label>
        <label class="checkbox-row" style="margin-top:11px;">
          <input type="checkbox" name="is_verified" value="1" @checked(old('is_verified', $property->is_verified))>
          Verified listing
        </label>
      </div>
    </div>

    @if ($property->images)
      <label>Current photos (click to remove)</label>
      <div class="img-grid">
        @foreach ($property->images as $path)
          <label>
            <img src="{{ Illuminate\Support\Facades\Storage::disk('public')->url($path) }}"
                 alt="Property photo" loading="lazy" decoding="async">
            <input type="checkbox" name="remove_images[]" value="{{ $path }}" style="position:absolute; top:6px; right:6px; z-index:2;">
            <span class="remove-overlay">Remove</span>
          </label>
        @endforeach
      </div>
    @endif

    <label for="images">Add more photos</label>
    <input id="images" name="images[]" type="file" accept="image/*" multiple style="margin-bottom:20px;">

    <div style="margin-top:6px;">
      <button type="submit" class="btn btn-primary">Save changes</button>
      <a href="{{ route('admin.properties.index') }}" style="margin-left:14px; font-size:13.5px; color:rgba(19,28,43,0.6);">Cancel</a>
    </div>
  </form>
</div>

@endsection
