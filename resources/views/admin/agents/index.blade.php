@extends('layouts.admin')

@section('page-title', 'Agents & Users')

@section('content')

<div class="panel">
  <table>
    <thead>
      <tr><th>Name</th><th>Email</th><th>Role</th><th>Listings</th><th>Verified</th><th></th></tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
        <tr>
          <td style="font-weight:600;">{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td style="text-transform:capitalize;">{{ $user->role }}</td>
          <td>{{ $user->properties_count }}</td>
          <td>
            <span class="badge {{ $user->is_verified ? 'badge-green' : 'badge-gray' }}">
              {{ $user->is_verified ? 'Verified' : 'Unverified' }}
            </span>
          </td>
          <td>
            @if ($user->role !== 'admin')
              <form action="{{ route('admin.agents.toggle-verified', $user) }}" method="POST">
                @csrf
                <button type="submit" class="link-action link-forest">
                  {{ $user->is_verified ? 'Remove verification' : 'Verify' }}
                </button>
              </form>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection
