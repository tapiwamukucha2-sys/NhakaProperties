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
        $budget = $request->query('budget');

        [$minPrice, $maxPrice] = $this->parseBudget($budget);

        $listings = Property::published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($location !== '', fn ($q) => $q->where(function ($q) use ($location) {
                $q->where('location', 'like', "%{$location}%")
                    ->orWhere('title', 'like', "%{$location}%")
                    ->orWhere('province', 'like', "%{$location}%");
            }))
            ->when($minPrice !== null, fn ($q) => $q->where('price', '>=', $minPrice))
            ->when($maxPrice !== null, fn ($q) => $q->where('price', '<=', $maxPrice))
            ->latest()
            ->get();

        $categories = ['rent' => 'Rent', 'buy' => 'Buy', 'land' => 'Land', 'commercial' => 'Commercial'];

        return view('browse', [
            'listings' => $listings,
            'categories' => $categories,
            'activeCategory' => $category,
            'location' => $location,
            'budget' => $budget,
        ]);
    }

    private function parseBudget(?string $budget): array
    {
        return match ($budget) {
            '0-200' => [0, 200],
            '200-600' => [200, 600],
            '600-1500' => [600, 1500],
            '1500+' => [1500, null],
            default => [null, null],
        };
    }
}
