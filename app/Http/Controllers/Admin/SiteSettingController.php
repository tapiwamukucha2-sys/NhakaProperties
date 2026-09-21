<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->role === 'admin', 403);

        $defaults = SiteSetting::defaults();
        $values = collect($defaults)->keys()->mapWithKeys(fn ($key) => [
            $key => SiteSetting::get($key, $defaults[$key]),
        ]);

        return view('admin.settings.index', compact('values'));
    }

    public function update(Request $request)
    {
        abort_unless($request->user()->role === 'admin', 403);

        $data = $request->validate([
            'category_rent_desc' => ['required', 'string', 'max:500'],
            'category_buy_desc' => ['required', 'string', 'max:500'],
            'category_land_desc' => ['required', 'string', 'max:500'],
            'category_commercial_desc' => ['required', 'string', 'max:500'],
            'trust_heading' => ['required', 'string', 'max:255'],
            'trust_lede' => ['required', 'string', 'max:1000'],
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value);
        }

        return back()->with('status', 'Site content updated.');
    }
}
