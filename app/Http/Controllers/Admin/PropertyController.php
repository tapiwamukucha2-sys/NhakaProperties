<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    use StoresImages;

    public function index(Request $request)
    {
        $this->authorizeAdmin($request);

        $properties = Property::with('user')->latest()->get();

        return view('admin.properties.index', [
            'pending' => $properties->where('status', 'pending')->values(),
            'published' => $properties->where('status', 'published')->values(),
            'rejected' => $properties->where('status', 'rejected')->values(),
        ]);
    }

    public function publish(Request $request, Property $property)
    {
        $this->authorizeAdmin($request);

        $property->update(['status' => 'published', 'is_verified' => true]);

        return back()->with('status', "\"{$property->title}\" is now published.");
    }

    public function reject(Request $request, Property $property)
    {
        $this->authorizeAdmin($request);

        $property->update(['status' => 'rejected', 'is_verified' => false]);

        return back()->with('status', "\"{$property->title}\" was rejected.");
    }

    public function edit(Request $request, Property $property)
    {
        $this->authorizeAdmin($request);

        return view('admin.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $this->authorizeAdmin($request);

        $data = $request->validate([
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
            'status' => ['required', 'in:draft,pending,published,rejected'],
            'is_verified' => ['nullable', 'boolean'],
        ]);

        $data['is_verified'] = $request->boolean('is_verified');

        $existingImages = $property->images ?? [];
        $toRemove = $request->input('remove_images', []);

        foreach ($toRemove as $path) {
            Storage::disk('public')->delete($path);
        }

        $existingImages = array_values(array_diff($existingImages, $toRemove));

        $newImages = $this->storeUploadedImages($request->file('images', []), 'properties', 'images');

        $data['images'] = array_merge($existingImages, $newImages);

        $property->update($data);

        return redirect()->route('admin.properties.index')->with('status', "\"{$property->title}\" updated.");
    }

    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user()?->role === 'admin', 403);
    }
}
