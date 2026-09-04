<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $location = trim((string) $request->query('location'));

        $listings = Property::published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($location !== '', fn ($q) => $q->where(function ($q) use ($location) {
                $q->where('location', 'like', "%{$location}%")
                    ->orWhere('title', 'like', "%{$location}%")
                    ->orWhere('province', 'like', "%{$location}%");
            }))
            ->latest()
            ->get();

        $categories = ['rent' => 'Rent', 'buy' => 'Buy', 'land' => 'Land', 'commercial' => 'Commercial'];

        return view('browse', [
            'listings' => $listings,
            'categories' => $categories,
            'activeCategory' => $category,
            'location' => $location,
        ]);
    }
}
