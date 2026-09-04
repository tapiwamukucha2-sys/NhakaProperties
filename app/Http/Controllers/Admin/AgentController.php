<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->role === 'admin', 403);

        $users = User::withCount('properties')->latest()->get();

        return view('admin.agents.index', ['users' => $users]);
    }

    public function toggleVerified(Request $request, User $user)
    {
        abort_unless($request->user()->role === 'admin', 403);

        $user->update([
            'is_verified' => ! $user->is_verified,
            'verified_at' => $user->is_verified ? null : now(),
        ]);

        return back()->with('status', $user->is_verified ? "{$user->name} is now verified." : "{$user->name}'s verification was removed.");
    }
}
