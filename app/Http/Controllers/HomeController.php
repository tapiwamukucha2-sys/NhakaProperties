<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\Property;
use App\Models\SiteSetting;
use App\Models\User;
use App\Support\SubscriptionPlans;

class HomeController extends Controller
{
    public function index()
    {
        $dbHeroSlides = HeroSlide::type('hero')->active()->ordered()->get();

        $heroSlides = $dbHeroSlides->isNotEmpty()
            ? $dbHeroSlides->map(fn ($s) => ['url' => $s->url(), 'price' => $s->caption_price, 'location' => $s->caption_location])
            : collect(['estate-day.jpg', 'estate-night.jpg', 'estate-dusk.jpg'])
                ->map(fn ($file) => ['url' => asset('images/hero/'.$file), 'price' => null, 'location' => null]);

        $defaults = SiteSetting::defaults();

        $categoryMeta = [
            'rent' => ['title' => 'Rent a home', 'desc' => SiteSetting::get('category_rent_desc', $defaults['category_rent_desc']), 'style' => 'cat-1'],
            'buy' => ['title' => 'Buy a house', 'desc' => SiteSetting::get('category_buy_desc', $defaults['category_buy_desc']), 'style' => 'cat-2'],
            'land' => ['title' => 'Land & stands', 'desc' => SiteSetting::get('category_land_desc', $defaults['category_land_desc']), 'style' => 'cat-3'],
            'commercial' => ['title' => 'Commercial', 'desc' => SiteSetting::get('category_commercial_desc', $defaults['category_commercial_desc']), 'style' => 'cat-4'],
        ];

        $trustHeading = SiteSetting::get('trust_heading', $defaults['trust_heading']);
        $trustLede = SiteSetting::get('trust_lede', $defaults['trust_lede']);

        $categories = collect($categoryMeta)->map(function ($meta, $slug) {
            return array_merge($meta, [
                'slug' => $slug,
                'count' => Property::published()->where('category', $slug)->count(),
            ]);
        })->values();

        $listings = Property::published()->latest()->take(6)->get();

        $siteStats = [
            'listings' => Property::published()->count(),
            'provinces' => Property::published()->distinct('province')->count('province'),
            'agents' => User::whereIn('role', ['agent', 'landlord'])
                ->whereHas('properties', fn ($q) => $q->published())
                ->count(),
        ];

        $featuredAgent = User::whereIn('role', ['agent', 'landlord'])
            ->where('is_verified', true)
            ->whereHas('properties', fn ($q) => $q->published())
            ->withCount(['properties' => fn ($q) => $q->published()])
            ->orderByDesc('properties_count')
            ->first();

        $dbInteriors = HeroSlide::type('interior')->active()->ordered()->get();

        $interiors = $dbInteriors->isNotEmpty()
            ? $dbInteriors->map(fn ($s) => ['image_url' => $s->url(), 'caption' => $s->caption_price ?: ''])
            : collect([
                ['image' => 'images/interiors/modern-kitchen.jpg', 'caption' => 'Modern fitted kitchen'],
                ['image' => 'images/interiors/living-room.jpg', 'caption' => 'Furnished living room'],
                ['image' => 'images/interiors/bedroom-boucle.jpg', 'caption' => 'Designer main bedroom'],
                ['image' => 'images/interiors/bedroom-beige.jpg', 'caption' => 'Fitted wardrobes'],
                ['image' => 'images/interiors/kitchen-island.jpg', 'caption' => 'Open-plan kitchen island'],
                ['image' => 'images/interiors/rustic-kitchen.jpg', 'caption' => 'Character kitchen'],
                ['image' => 'images/interiors/bedroom-striped.jpg', 'caption' => 'Cosy guest bedroom'],
                ['image' => 'images/interiors/twin-room.jpg', 'caption' => 'Student twin room'],
            ])->map(fn ($i) => ['image_url' => asset($i['image']), 'caption' => $i['caption']]);

        $pricing = collect(SubscriptionPlans::all())->map(fn ($plan) => [
            'tier' => $plan['name'],
            'amount' => $plan['price'] ? '$'.$plan['price'] : 'Custom',
            'period' => $plan['period'] ? '/ '.$plan['period'] : '',
            'featured' => $plan['featured'] ?? false,
            'desc' => $plan['desc'],
            'features' => $plan['features'],
            'cta' => $plan['price'] ? 'Start listing' : 'Talk to us',
        ])->values();

        return view('home', compact('categories', 'listings', 'interiors', 'pricing', 'heroSlides', 'siteStats', 'trustHeading', 'trustLede', 'featuredAgent'));
    }
}
