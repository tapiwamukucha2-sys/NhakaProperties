<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $staticUrls = [
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('browse'), 'priority' => '0.9'],
            ['loc' => route('map'), 'priority' => '0.6'],
            ['loc' => route('agents'), 'priority' => '0.6'],
            ['loc' => route('about'), 'priority' => '0.5'],
        ];

        $listingUrls = Property::published()->get()->map(fn ($property) => [
            'loc' => route('listings.show', $property->slug),
            'lastmod' => $property->updated_at->toAtomString(),
            'priority' => '0.8',
        ]);

        $urls = collect($staticUrls)->concat($listingUrls);

        return Response::view('sitemap', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }
}
