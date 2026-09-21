<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    public function dashboard(Request $request)
    {
        $properties = $request->user()->properties()->latest()->get();

        return view('dashboard', [
            'properties' => $properties,
            'stats' => [
                'total' => $properties->count(),
                'published' => $properties->where('status', 'published')->count(),
                'pending' => $properties->where('status', 'pending')->count(),
            ],
        ]);
    }

    public function create(Request $request)
    {
        if (! $request->user()->canCreateListing()) {
            return redirect()->route('subscribe.index')->with('status', 'You\'ve reached your plan\'s listing limit — choose a plan to list more properties.');
        }

        return view('properties.create');
    }

    public function store(Request $request)
    {
        if (! $request->user()->canCreateListing()) {
            return redirect()->route('subscribe.index')->with('status', 'You\'ve reached your plan\'s listing limit — choose a plan to list more properties.');
        }

        $data = $this->validateProperty($request);

        $data['images'] = $this->storeImages($request);
        $data['status'] = 'pending';

        $request->user()->properties()->create($data);

        return redirect()->route('dashboard')->with('status', 'Property submitted for review.');
    }

    public function edit(Property $property)
    {
        $this->authorizeOwner($property);

        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $this->authorizeOwner($property);

        $data = $this->validateProperty($request);

        $existingImages = $property->images ?? [];
        $toRemove = $request->input('remove_images', []);

        foreach ($toRemove as $path) {
            Storage::disk('public')->delete($path);
        }

        $existingImages = array_values(array_diff($existingImages, $toRemove));
        $newImages = $this->storeImages($request);
        $allImages = array_merge($existingImages, $newImages);

        if (count($allImages) < 3) {
            return back()->withErrors(['images' => 'A property needs at least 3 photos in total — please add more.'])->withInput();
        }

        $data['images'] = $allImages;

        $property->update($data);

        return redirect()->route('dashboard')->with('status', 'Property updated.');
    }

    public function destroy(Property $property)
    {
        $this->authorizeOwner($property);

        foreach ($property->images ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }

        $property->delete();

        return redirect()->route('dashboard')->with('status', 'Property removed.');
    }

    private function validateProperty(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['required', 'in:rent,buy,land,commercial'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_period' => ['required', 'in:month,once'],
            'location' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'size_sqm' => ['nullable', 'integer', 'min:0'],
            'images' => [Rule::requiredIf(fn () => $request->routeIs('properties.store')), 'array', $request->routeIs('properties.store') ? 'min:3' : 'sometimes'],
            'images.*' => ['image', 'max:4096'],
        ]);
    }

    private function storeImages(Request $request): array
    {
        if (! $request->hasFile('images')) {
            return [];
        }

        return collect($request->file('images'))
            ->map(fn ($file) => $file->store('properties', 'public'))
            ->all();
    }

    private function authorizeOwner(Property $property): void
    {
        abort_unless($property->user_id === request()->user()->id, 403);
    }
}
