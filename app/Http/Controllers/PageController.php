<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;

class PageController extends Controller
{
    public function map()
    {
        $provinces = collect([
            ['name' => 'Harare', 'blurb' => 'Borrowdale, Avondale, Waterfalls, Vainona and more.'],
            ['name' => 'Bulawayo', 'blurb' => 'Hillside, Nketa, Suburbs and the CBD.'],
            ['name' => 'Manicaland', 'blurb' => 'Mutare and surrounding growth points.'],
            ['name' => 'Midlands', 'blurb' => 'Gweru and Kwekwe residential stands.'],
            ['name' => 'Mashonaland East', 'blurb' => 'Marondera, Ruwa commuter belt.'],
            ['name' => 'Mashonaland West', 'blurb' => 'Chinhoyi, Kadoma housing.'],
            ['name' => 'Matabeleland North', 'blurb' => 'Victoria Falls tourism-adjacent stands.'],
            ['name' => 'Masvingo', 'blurb' => 'Masvingo town residential and commercial.'],
        ])->map(fn ($p) => array_merge($p, [
            'count' => Property::published()->where('province', $p['name'])->count(),
        ]));

        return view('map', ['provinces' => $provinces]);
    }

    public function agents()
    {
        $agents = User::whereIn('role', ['agent', 'landlord'])
            ->withCount(['properties' => fn ($q) => $q->published()])
            ->get()
            ->filter(fn ($user) => $user->properties_count > 0)
            ->values();

        return view('agents', compact('agents'));
    }

    public function about()
    {
        return view('about');
    }
}
