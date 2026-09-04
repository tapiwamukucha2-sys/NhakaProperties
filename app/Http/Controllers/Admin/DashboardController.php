<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->role === 'admin', 403);

        return view('admin.dashboard', [
            'totalProperties' => Property::count(),
            'pendingProperties' => Property::where('status', 'pending')->count(),
            'publishedProperties' => Property::where('status', 'published')->count(),
            'totalAgents' => User::whereIn('role', ['agent', 'landlord'])->count(),
            'totalUsers' => User::count(),
            'heroSlideCount' => HeroSlide::count(),
            'activeHeroSlideCount' => HeroSlide::active()->count(),
            'recentProperties' => Property::with('user')->latest()->take(5)->get(),
        ]);
    }
}
