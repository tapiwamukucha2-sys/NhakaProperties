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
        $bedrooms = $request->query('bedrooms');
        $sort = $request->query('sort', 'newest');

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
            ->when($bedrooms, fn ($q) => $q->where('bedrooms', '>=', (int) $bedrooms))
            ->when($sort === 'price_asc', fn ($q) => $q->orderBy('price', 'asc'))
            ->when($sort === 'price_desc', fn ($q) => $q->orderBy('price', 'desc'))
            ->when($sort === 'newest' || ! $sort, fn ($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        $categories = ['rent' => 'Rent', 'buy' => 'Buy', 'land' => 'Land', 'commercial' => 'Commercial'];

        return view('browse', [
            'listings' => $listings,
            'categories' => $categories,
            'activeCategory' => $category,
            'location' => $location,
            'budget' => $budget,
            'bedrooms' => $bedrooms,
            'sort' => $sort,
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
