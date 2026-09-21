@extends('layouts.admin')

@section('page-title', 'Subscriptions')

@section('content')

<div style="margin-bottom:34px;">
  <div class="panel-head" style="border:none; padding-left:0;">Pending payment claims ({{ $pending->count() }})</div>
  <div class="panel">
    @if ($pending->isEmpty())
      <div style="padding:40px; text-align:center; color:rgba(19,28,43,0.5);">No payment claims waiting on review.</div>
    @else
      <table>
        <thead>
          <tr><th>User</th><th>Plan</th><th>Amount</th><th>Method</th><th>Reference</th><th></th></tr>
        </thead>
        <tbody>
          @foreach ($pending as $sub)
            <tr>
              <td style="font-weight:600;">{{ $sub->user->name }}<br><span style="font-weight:400; color:rgba(19,28,43,0.5); font-size:12px;">{{ $sub->user->email }}</span></td>
              <td style="text-transform:capitalize;">{{ $sub->plan }}</td>
              <td>${{ number_format($sub->amount, 2) }}</td>
              <td style="text-transform:capitalize;">{{ $sub->method }}</td>
              <td>{{ $sub->reference ?: '—' }}</td>
              <td>
                <form action="{{ route('admin.subscriptions.approve', $sub) }}" method="POST" style="display:inline;">
                  @csrf
                  <button type="submit" class="link-action link-forest">Approve</button>
                </form>
                <span style="color:rgba(19,28,43,0.25); margin:0 6px;">·</span>
                <form action="{{ route('admin.subscriptions.reject', $sub) }}" method="POST" style="display:inline;">
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

<div>
  <div class="panel-head" style="border:none; padding-left:0;">Active subscriptions ({{ $active->count() }})</div>
  <div class="panel">
    @if ($active->isEmpty())
      <div style="padding:40px; text-align:center; color:rgba(19,28,43,0.5);">No active subscriptions yet.</div>
    @else
      <table>
        <thead>
          <tr><th>User</th><th>Plan</th><th>Approved</th><th>Expires</th></tr>
        </thead>
        <tbody>
          @foreach ($active as $sub)
            <tr>
              <td style="font-weight:600;">{{ $sub->user->name }}</td>
              <td style="text-transform:capitalize;">{{ $sub->plan }}</td>
              <td>{{ $sub->approved_at?->format('d M Y') }}</td>
              <td>{{ $sub->expires_at?->format('d M Y') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>

@endsection
