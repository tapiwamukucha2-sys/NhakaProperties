<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        NewsletterSubscriber::firstOrCreate(['email' => $data['email']]);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'subscribed']);
        }

        return back()->with('status', "You're subscribed — welcome to ".config('app.name').'!');
    }
}
