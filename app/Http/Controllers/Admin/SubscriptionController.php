<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->role === 'admin', 403);

        $subscriptions = Subscription::with('user')->latest()->get();

        return view('admin.subscriptions.index', [
            'pending' => $subscriptions->where('status', 'pending')->values(),
            'active' => $subscriptions->where('status', 'active')->values(),
            'rejected' => $subscriptions->where('status', 'rejected')->values(),
        ]);
    }

    public function approve(Request $request, Subscription $subscription)
    {
        abort_unless($request->user()->role === 'admin', 403);

        $subscription->update([
            'status' => 'active',
            'approved_at' => now(),
            'expires_at' => now()->addMonth(),
        ]);

        return back()->with('status', "{$subscription->user->name}'s {$subscription->plan} plan activated.");
    }

    public function reject(Request $request, Subscription $subscription)
    {
        abort_unless($request->user()->role === 'admin', 403);

        $subscription->update(['status' => 'rejected']);

        return back()->with('status', "{$subscription->user->name}'s payment claim rejected.");
    }
}
