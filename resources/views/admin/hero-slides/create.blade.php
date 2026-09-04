@extends('layouts.admin')

@section('page-title', 'Add ' . ($type === 'hero' ? 'hero background photo' : 'interior gallery photo'))

@section('styles')
  .form-panel{background:var(--paper-2); border:1px solid var(--line); border-radius:12px; padding:28px; max-width:560px;}
  .form-panel label{display:block; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.03em; color:rgba(19,28,43,0.55); margin-bottom:6px;}
  .form-panel input[type=text], .form-panel input[type=number]{width:100%; padding:11px 13px; border:1px solid var(--line); border-radius:7px; font-family:inherit; font-size:14px; margin-bottom:20px;}
  .form-panel input[type=file]{margin-bottom:8px;}
  .form-panel .hint{font-size:12.5px; color:rgba(19,28,43,0.5); margin-bottom:10px;}
  .form-panel .row{display:grid; grid-template-columns:1fr 1fr; gap:16px;}
  .error-text{color:#dc2626; font-size:12.5px; margin-top:-14px; margin-bottom:14px;}
@endsection

@section('content')

<div class="form-panel">
  <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type" value="{{ $type }}">

    <label for="image">Photo</label>
    <p class="hint">Landscape photos work best{{ $type === 'hero' ? ' — this fills the full-width hero background.' : '.' }}</p>
    <input id="image" name="image" type="file" accept="image/*" required>
    @error('image') <div class="error-text">{{ $message }}</div> @enderror

    @if ($type === 'hero')
      <div class="row" style="margin-top:20px;">
        <div>
          <label for="caption_price">Price caption (optional)</label>
          <input id="caption_price" name="caption_price" type="text" value="{{ old('caption_price') }}" placeholder="e.g. \$950 / mo">
        </div>
        <div>
          <label for="caption_location">Location caption (optional)</label>
          <input id="caption_location" name="caption_location" type="text" value="{{ old('caption_location') }}" placeholder="e.g. Borrowdale, Harare">
        </div>
      </div>
    @else
      <div style="margin-top:20px;">
        <label for="caption_price">Caption (optional)</label>
        <input id="caption_price" name="caption_price" type="text" value="{{ old('caption_price') }}" placeholder="e.g. Modern fitted kitchen">
      </div>
    @endif

    <label for="sort_order">Display order</label>
    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', 0) }}" style="width:120px;">
    <p class="hint">Lower numbers show first.</p>

    <div style="margin-top:16px;">
      <button type="submit" class="btn btn-primary">Add slide</button>
      <a href="{{ route('admin.hero-slides.index', ['type' => $type]) }}" style="margin-left:14px; font-size:13.5px; color:rgba(19,28,43,0.6);">Cancel</a>
    </div>
  </form>
</div>

@endsection
