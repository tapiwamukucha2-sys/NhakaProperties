<?php

namespace App\Http\Controllers;

use App\Models\Property;

class ListingController extends Controller
{
    public function show(string $slug)
    {
        $property = Property::published()->where('slug', $slug)->firstOrFail();

        return view('listings.show', ['property' => $property]);
    }
}
