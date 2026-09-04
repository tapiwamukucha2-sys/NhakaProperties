@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')

<div class="stat-grid">
  <div class="stat-card">
    <div class="label">Total properties</div>
    <div class="num">{{ $totalProperties }}</div>
    <a href="{{ route('admin.properties.index') }}">Manage properties →</a>
  </div>
  <div class="stat-card">
    <div class="label">Pending review</div>
    <div class="num" style="color:var(--gold);">{{ $pendingProperties }}</div>
    <div class="sub">Waiting on approval</div>
    <a href="{{ route('admin.properties.index') }}">Review now →</a>
  </div>
  <div class="stat-card">
    <div class="label">Published live</div>
    <div class="num" style="color:var(--forest);">{{ $publishedProperties }}</div>
    <div class="sub">Visible on the site</div>
  </div>
  <div class="stat-card">
    <div class="label">Hero slides</div>
    <div class="num">{{ $activeHeroSlideCount }}<span style="font-size:16px; color:rgba(19,28,43,0.4);"> / {{ $heroSlideCount }}</span></div>
    <div class="sub">Active / total</div>
    <a href="{{ route('admin.hero-slides.index') }}">Manage slides →</a>
  </div>
</div>

<div class="stat-grid" style="grid-template-columns:repeat(2,1fr);">
  <div class="stat-card">
    <div class="label">Agents & landlords</div>
    <div class="num">{{ $totalAgents }}</div>
    <a href="{{ route('admin.agents.index') }}">View agents →</a>
  </div>
  <div class="stat-card">
    <div class="label">Total registered users</div>
    <div class="num">{{ $totalUsers }}</div>
    <div class="sub">Renters, landlords, agents & admins</div>
  </div>
</div>

<div class="panel">
  <div class="panel-head">Recently submitted properties</div>
  @if ($recentProperties->isEmpty())
    <div style="padding:40px; text-align:center; color:rgba(19,28,43,0.5);">Nothing submitted yet.</div>
  @else
    <table>
      <thead>
        <tr><th>Title</th><th>Listed by</th><th>Category</th><th>Status</th></tr>
      </thead>
      <tbody>
        @foreach ($recentProperties as $property)
          <tr>
            <td style="font-weight:600;">{{ $property->title }}</td>
            <td>{{ $property->user->name }}</td>
            <td style="text-transform:capitalize;">{{ $property->category }}</td>
            <td>
              <span @class([
                'badge',
                'badge-green' => $property->status === 'published',
                'badge-gold' => $property->status === 'pending',
                'badge-red' => $property->status === 'rejected',
                'badge-gray' => $property->status === 'draft',
              ])>{{ ucfirst($property->status) }}</span>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>

@endsection
