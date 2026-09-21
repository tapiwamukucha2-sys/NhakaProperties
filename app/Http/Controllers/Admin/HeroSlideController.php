<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    use StoresImages;

    private const TYPES = ['hero' => 'Hero background', 'interior' => 'Interior showcase'];

    public function index(Request $request)
    {
        $this->authorizeAdmin($request);

        $type = $request->query('type', 'hero');

        return view('admin.hero-slides.index', [
            'slides' => HeroSlide::type($type)->ordered()->get(),
            'type' => $type,
            'types' => self::TYPES,
        ]);
    }

    public function create(Request $request)
    {
        $this->authorizeAdmin($request);

        return view('admin.hero-slides.create', [
            'type' => $request->query('type', 'hero'),
            'types' => self::TYPES,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin($request);

        $data = $request->validate([
            'type' => ['required', 'in:hero,interior'],
            'image' => ['required', 'image', 'max:6144'],
            'caption_price' => ['nullable', 'string', 'max:255'],
            'caption_location' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        HeroSlide::create([
            'type' => $data['type'],
            'image_path' => $this->storeUploadedImage($request->file('image'), 'hero-slides', 'image'),
            'caption_price' => $data['caption_price'] ?? null,
            'caption_location' => $data['caption_location'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.hero-slides.index', ['type' => $data['type']])->with('status', 'Slide added.');
    }

    public function toggle(Request $request, HeroSlide $heroSlide)
    {
        $this->authorizeAdmin($request);

        $heroSlide->update(['is_active' => ! $heroSlide->is_active]);

        return back()->with('status', $heroSlide->is_active ? 'Slide activated.' : 'Slide deactivated.');
    }

    public function destroy(Request $request, HeroSlide $heroSlide)
    {
        $this->authorizeAdmin($request);

        Storage::disk('public')->delete($heroSlide->image_path);
        $heroSlide->delete();

        return back()->with('status', 'Slide removed.');
    }

    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user()?->role === 'admin', 403);
    }
}
