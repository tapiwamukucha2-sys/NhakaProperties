@php
    $v = fn ($field, $default = '') => old($field, $property?->{$field} ?? $default);
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <div class="sm:col-span-2">
        <x-input-label for="title" value="Title" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ $v('title') }}" required autofocus />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div class="sm:col-span-2">
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-[--line] shadow-sm focus:border-[--forest] focus:ring-[--forest]">{{ $v('description') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="category" value="Category" />
        <select id="category" name="category" class="mt-1 block w-full rounded-md border-[--line] shadow-sm focus:border-[--forest] focus:ring-[--forest]" required>
            @foreach (['rent' => 'Rent', 'buy' => 'Buy', 'land' => 'Land / stand', 'commercial' => 'Commercial'] as $value => $label)
                <option value="{{ $value }}" @selected($v('category') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="price_period" value="Pricing" />
        <select id="price_period" name="price_period" class="mt-1 block w-full rounded-md border-[--line] shadow-sm focus:border-[--forest] focus:ring-[--forest]" required>
            <option value="month" @selected($v('price_period') === 'month')>Per month (rental)</option>
            <option value="once" @selected($v('price_period', 'once') === 'once')>One-time (sale)</option>
        </select>
        <x-input-error :messages="$errors->get('price_period')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="price" value="Price (USD)" />
        <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="mt-1 block w-full" value="{{ $v('price') }}" required />
        <x-input-error :messages="$errors->get('price')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="province" value="Province" />
        <x-text-input id="province" name="province" type="text" class="mt-1 block w-full" value="{{ $v('province') }}" placeholder="e.g. Harare" required />
        <x-input-error :messages="$errors->get('province')" class="mt-2" />
    </div>

    <div class="sm:col-span-2">
        <x-input-label for="location" value="Suburb / area" />
        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" value="{{ $v('location') }}" placeholder="e.g. Borrowdale, Harare" required />
        <x-input-error :messages="$errors->get('location')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="bedrooms" value="Bedrooms" />
        <x-text-input id="bedrooms" name="bedrooms" type="number" min="0" class="mt-1 block w-full" value="{{ $v('bedrooms') }}" />
        <x-input-error :messages="$errors->get('bedrooms')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="bathrooms" value="Bathrooms" />
        <x-text-input id="bathrooms" name="bathrooms" type="number" min="0" class="mt-1 block w-full" value="{{ $v('bathrooms') }}" />
        <x-input-error :messages="$errors->get('bathrooms')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="size_sqm" value="Size (m²)" />
        <x-text-input id="size_sqm" name="size_sqm" type="number" min="0" class="mt-1 block w-full" value="{{ $v('size_sqm') }}" />
        <x-input-error :messages="$errors->get('size_sqm')" class="mt-2" />
    </div>
</div>

<div class="my-8 border-t border-[--line]"></div>

<div>
    <x-input-label for="images" value="Photos" />
    <p class="text-sm text-[--ink]/60 mt-1 mb-3">A listing needs at least 3 photos before it can be published.</p>

    @if ($property && $property->images)
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4">
            @foreach ($property->images as $path)
                <label class="relative block rounded-lg overflow-hidden border border-[--line] cursor-pointer group">
                    <img src="{{ Illuminate\Support\Facades\Storage::disk('public')->url($path) }}" class="w-full h-24 object-cover">
                    <span class="absolute inset-0 bg-black/0 group-has-[:checked]:bg-black/60 flex items-center justify-center transition">
                        <span class="hidden group-has-[:checked]:inline text-white text-xs font-bold">Remove</span>
                    </span>
                    <input type="checkbox" name="remove_images[]" value="{{ $path }}" class="absolute top-2 right-2">
                </label>
            @endforeach
        </div>
    @endif

    <input id="images" name="images[]" type="file" accept="image/*" multiple
           class="block w-full text-sm border border-[--line] rounded-md file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-[--forest] file:text-white file:font-semibold file:text-sm"
           {{ ($property && $property->images && count($property->images) >= 3) ? '' : 'required' }}>
    <x-input-error :messages="$errors->get('images')" class="mt-2" />
    <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
</div>

<div class="my-8 border-t border-[--line]"></div>
