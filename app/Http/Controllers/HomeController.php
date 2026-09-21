<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\Property;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $dbHeroSlides = HeroSlide::type('hero')->active()->ordered()->get();

        $heroSlides = $dbHeroSlides->isNotEmpty()
            ? $dbHeroSlides->map(fn ($s) => ['url' => $s->url(), 'price' => $s->caption_price, 'location' => $s->caption_location])
            : collect(['estate-day.jpg', 'estate-night.jpg', 'estate-dusk.jpg'])
                ->map(fn ($file) => ['url' => asset('images/hero/'.$file), 'price' => null, 'location' => null]);

        $categoryMeta = [
            'rent' => ['title' => 'Rent a home', 'desc' => 'Rooms, cottages, flats and full houses — updated daily.', 'style' => 'cat-1'],
            'buy' => ['title' => 'Buy a house', 'desc' => 'Freehold and cluster homes across every province.', 'style' => 'cat-2'],
            'land' => ['title' => 'Land & stands', 'desc' => 'Residential and agricultural stands, title-verified.', 'style' => 'cat-3'],
            'commercial' => ['title' => 'Commercial', 'desc' => 'Shops, offices and warehouses ready to lease or buy.', 'style' => 'cat-4'],
        ];

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

        $pricing = [
            [
                'tier' => 'Starter', 'amount' => '$5', 'period' => '/ month', 'featured' => false,
                'desc' => 'For a landlord with one or two properties to fill.',
                'features' => ['Up to 2 active listings', 'WhatsApp inquiry forwarding', 'Basic listing analytics'],
                'cta' => 'Start listing',
            ],
            [
                'tier' => 'Agent', 'amount' => '$18', 'period' => '/ month', 'featured' => true,
                'desc' => 'For agents actively managing a portfolio.',
                'features' => ['Up to 25 active listings', 'Featured placement rotation', 'Verified agent badge', 'Lead inbox with reply tracking'],
                'cta' => 'Start listing',
            ],
            [
                'tier' => 'Developer', 'amount' => 'Custom', 'period' => '', 'featured' => false,
                'desc' => 'For new developments and large agencies.',
                'features' => ['Unlimited listings', 'Dedicated project page', 'Homepage & category placement', 'Account manager'],
                'cta' => 'Talk to us',
            ],
        ];

        return view('home', compact('categories', 'listings', 'interiors', 'pricing', 'heroSlides', 'siteStats'));
    }
}
