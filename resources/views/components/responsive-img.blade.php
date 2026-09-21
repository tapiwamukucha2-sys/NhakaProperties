@props([])
@if (! empty($sources))
<picture>
    @if (! empty($sources['avif']))
        <source type="image/avif" srcset="{{ $srcset('avif') }}" @if ($sizes) sizes="{{ $sizes }}" @endif>
    @endif
    @if (! empty($sources['webp']))
        <source type="image/webp" srcset="{{ $srcset('webp') }}" @if ($sizes) sizes="{{ $sizes }}" @endif>
    @endif
    <img src="{{ $src }}" alt="{{ $alt }}"
         @if ($width) width="{{ $width }}" @endif
         @if ($height) height="{{ $height }}" @endif
         loading="{{ $loading }}" decoding="async"
         @if ($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
         {{ $attributes }}>
</picture>
@else
<img src="{{ $src }}" alt="{{ $alt }}"
     @if ($width) width="{{ $width }}" @endif
     @if ($height) height="{{ $height }}" @endif
     loading="{{ $loading }}" decoding="async"
     @if ($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
     {{ $attributes }}>
@endif
