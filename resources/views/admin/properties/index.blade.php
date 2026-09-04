@extends('layouts.admin')

@section('page-title', 'Property approvals')

@section('content')

<div style="margin-bottom:34px;">
  <div class="panel-head" style="border:none; padding-left:0;">Pending review ({{ $pending->count() }})</div>
  <div class="panel">
    @if ($pending->isEmpty())
      <div style="padding:40px; text-align:center; color:rgba(19,28,43,0.5);">Nothing waiting on review.</div>
    @else
      <table>
        <thead>
          <tr><th>Title</th><th>Listed by</th><th>Category</th><th>Price</th><th>Photos</th><th></th></tr>
        </thead>
        <tbody>
          @foreach ($pending as $property)
            <tr>
              <td style="font-weight:600;">{{ $property->title }}</td>
              <td>{{ $property->user->name }}</td>
              <td style="text-transform:capitalize;">{{ $property->category }}</td>
              <td>{{ $property->displayPrice() }}</td>
              <td>{{ count($property->images ?? []) }}</td>
              <td>
                <a href="{{ route('admin.properties.edit', $property) }}" class="link-action link-forest">Edit</a>
                <span style="color:rgba(19,28,43,0.25); margin:0 6px;">·</span>
                <form action="{{ route('admin.properties.publish', $property) }}" method="POST" style="display:inline;">
                  @csrf
                  <button type="submit" class="link-action link-forest">Publish</button>
                </form>
                <span style="color:rgba(19,28,43,0.25); margin:0 6px;">·</span>
                <form action="{{ route('admin.properties.reject', $property) }}" method="POST" style="display:inline;">
                  @csrf
                  <button type="submit" class="link-action link-red">Reject</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>

<div style="margin-bottom:34px;">
  <div class="panel-head" style="border:none; padding-left:0;">Published ({{ $published->count() }})</div>
  <div class="panel">
    <table>
      <thead>
        <tr><th>Title</th><th>Listed by</th><th>Category</th><th>Price</th><th></th></tr>
      </thead>
      <tbody>
        @foreach ($published as $property)
          <tr>
            <td style="font-weight:600;">
              @if ($property->slug)
                <a href="{{ route('listings.show', $property->slug) }}" target="_blank" style="text-decoration:underline;">{{ $property->title }}</a>
              @else
                {{ $property->title }}
              @endif
            </td>
            <td>{{ $property->user->name }}</td>
            <td style="text-transform:capitalize;">{{ $property->category }}</td>
            <td>{{ $property->displayPrice() }}</td>
            <td>
              <a href="{{ route('admin.properties.edit', $property) }}" class="link-action link-forest">Edit</a>
              <span style="color:rgba(19,28,43,0.25); margin:0 6px;">·</span>
              <form action="{{ route('admin.properties.reject', $property) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="link-action link-red">Unpublish</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@if ($rejected->isNotEmpty())
  <div>
    <div class="panel-head" style="border:none; padding-left:0;">Rejected ({{ $rejected->count() }})</div>
    <div class="panel">
      <table>
        <tbody>
          @foreach ($rejected as $property)
            <tr>
              <td style="font-weight:600;">{{ $property->title }}</td>
              <td>{{ $property->user->name }}</td>
              <td>
                <form action="{{ route('admin.properties.publish', $property) }}" method="POST">
                  @csrf
                  <button type="submit" class="link-action link-forest">Reconsider & publish</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif

@endsection
