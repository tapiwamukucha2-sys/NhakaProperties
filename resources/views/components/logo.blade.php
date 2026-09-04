@props(['size' => 34])

<span class="nhaka-logo-mark" style="width:{{ $size }}px;height:{{ $size }}px;display:inline-flex;flex-shrink:0;">
    <svg viewBox="0 0 40 40" width="{{ $size }}" height="{{ $size }}" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="40" height="40" rx="10" fill="var(--forest, #123A6B)"/>
        <path d="M9 21.5L20 12L31 21.5" stroke="var(--paper-2, #fff)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M12.5 19V28.5H27.5V19" stroke="var(--paper-2, #fff)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
        <circle cx="20" cy="24.5" r="2.4" fill="var(--gold, #C08A28)"/>
    </svg>
</span>
