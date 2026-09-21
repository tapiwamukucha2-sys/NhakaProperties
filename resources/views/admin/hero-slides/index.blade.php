@extends('layouts.admin')

@section('page-title', 'Homepage Photos')

@section('page-actions')
  <a href="{{ route('admin.hero-slides.create', ['type' => $type]) }}" class="btn btn-primary">+ Add new photo</a>
@endsection

@section('styles')
  .tab-row{display:flex; gap:8px; margin-bottom:22px;}
  .tab-chip{padding:9px 18px; border-radius:20px; border:1px solid var(--line); background:var(--paper-2); font-size:13.5px; font-weight:600;}
  .tab-chip.active{background:var(--forest); color:#fff; border-color:var(--forest);}
@endsection

@section('content')

<div class="tab-row">
  @foreach ($types as $value => $label)
    <a href="{{ route('admin.hero-slides.index', ['type' => $value]) }}" class="tab-chip {{ $type === $value ? 'active' : '' }}">{{ $label }}</a>
  @endforeach
</div>

<p style="font-size:13.5px; color:rgba(19,28,43,0.6); margin-bottom:20px;">
  @if ($type === 'hero')
    These photos rotate as the full-bleed background behind the homepage hero text.
  @else
    These photos appear in the "Step inside real Nhaka homes" gallery on the homepage.
  @endif
  Active ones show in order; inactive ones are hidden.
</p>

<div class="panel">
  @if ($slides->isEmpty())
    <div style="padding:50px; text-align:center; color:rgba(19,28,43,0.55);">
      <p style="margin-bottom:16px;">No photos here yet — the homepage is using default fallback images.</p>
      <a href="{{ route('admin.hero-slides.create', ['type' => $type]) }}" class="btn btn-primary">Add your first photo</a>
    </div>
  @else
    <table>
      <thead>
        <tr><th>Image</th><th>Caption</th><th>Order</th><th>Status</th><th></th></tr>
      </thead>
      <tbody>
        @foreach ($slides as $slide)
          <tr>
            <td><img src="{{ $slide->url() }}" alt="Hero slide preview" width="96" height="64"
                     loading="lazy" decoding="async"
                     style="width:96px; height:64px; object-fit:cover; border-radius:6px; border:1px solid var(--line);"></td>
            <td>
              <div style="font-weight:600;">{{ $slide->caption_price ?: '—' }}</div>
              <div style="font-size:12px; color:rgba(19,28,43,0.55); margin-top:2px;">{{ $slide->caption_location ?: 'No location caption' }}</div>
            </td>
            <td>{{ $slide->sort_order }}</td>
            <td>
              <span class="badge {{ $slide->is_active ? 'badge-green' : 'badge-gray' }}">{{ $slide->is_active ? 'Active' : 'Inactive' }}</span>
            </td>
            <td>
              <form action="{{ route('admin.hero-slides.toggle', $slide) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="link-action link-forest">{{ $slide->is_active ? 'Deactivate' : 'Activate' }}</button>
              </form>
              <span style="color:rgba(19,28,43,0.25); margin:0 6px;">·</span>
              <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" style="display:inline;" onsubmit="return confirm('Remove this photo?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="link-action link-red">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>

@endsection
