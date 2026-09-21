<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Support\SubscriptionPlans;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $plans = SubscriptionPlans::all();
        $user = $request->user();

        return view('subscribe', [
            'plans' => $plans,
            'activeSubscription' => $user->activeSubscription(),
            'pendingSubscription' => $user->subscriptions()->where('status', 'pending')->latest()->first(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plan' => ['required', 'in:starter,agent,developer'],
            'method' => ['required', 'in:ecocash,paypal,other'],
            'reference' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $plan = SubscriptionPlans::find($data['plan']);

        $request->user()->subscriptions()->create([
            'plan' => $data['plan'],
            'status' => 'pending',
            'method' => $data['method'],
            'amount' => $plan['price'],
            'reference' => $data['reference'] ?? null,
            'note' => $data['note'] ?? null,
        ]);

        return redirect()->route('subscribe.index')->with('status', 'Payment claim submitted — we\'ll verify and activate your plan shortly.');
    }
}
