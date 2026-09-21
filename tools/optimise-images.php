<?php

/**
 * Generate AVIF and WebP derivatives for the static images in public/images.
 *
 * Uses PHP's bundled GD, so there is nothing to install. Originals are never
 * touched — they stay as the final <img src> fallback for browsers that take
 * neither modern format.
 *
 * Usage:  php tools/optimise-images.php [--force]
 */

const WIDTHS = [320, 640, 1280];
const AVIF_QUALITY = 52;
const WEBP_QUALITY = 78;

$force = in_array('--force', $argv, true);
$root = dirname(__DIR__);

foreach (['avif' => 'AVIF', 'webp' => 'WebP'] as $fn => $label) {
    if (! function_exists('image'.$fn)) {
        fwrite(STDERR, "GD has no $label support in this PHP build — aborting.\n");
        exit(1);
    }
}

$sources = glob($root.'/public/images/*/*.{jpg,jpeg,png}', GLOB_BRACE);
sort($sources);

$before = 0;
$after = 0;
$made = 0;
$skipped = 0;

foreach ($sources as $src) {
    $info = @getimagesize($src);
    if (! $info) {
        fwrite(STDERR, "  skip (unreadable): $src\n");
        continue;
    }

    [$srcW, $srcH] = $info;
    $before += filesize($src);
    $rel = substr($src, strlen($root) + 1);
    $stem = preg_replace('/\.(jpe?g|png)$/i', '', $src);

    printf("%-46s %4dx%-4d\n", substr($rel, 14), $srcW, $srcH);

    // Never upscale: keep widths at or below the source, and always
    // include the source width itself so the largest variant is lossless-ish.
    $targets = array_values(array_filter(WIDTHS, fn ($w) => $w < $srcW));
    $targets[] = $srcW;

    foreach ($targets as $w) {
        $h = (int) round($srcH * ($w / $srcW));

        foreach (['avif', 'webp'] as $fmt) {
            $out = sprintf('%s-%d.%s', $stem, $w, $fmt);

            if (! $force && file_exists($out) && filemtime($out) >= filemtime($src)) {
                $after += filesize($out);
                $skipped++;
                continue;
            }

            $im = match (strtolower(pathinfo($src, PATHINFO_EXTENSION))) {
                'png' => imagecreatefrompng($src),
                default => imagecreatefromjpeg($src),
            };
            if (! $im) {
                fwrite(STDERR, "  decode failed: $rel\n");
                continue 3;
            }

            $dst = imagecreatetruecolor($w, $h);
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            imagecopyresampled($dst, $im, 0, 0, 0, 0, $w, $h, $srcW, $srcH);

            $ok = $fmt === 'avif'
                ? imageavif($dst, $out, AVIF_QUALITY)
                : imagewebp($dst, $out, WEBP_QUALITY);

            imagedestroy($dst);
            imagedestroy($im);

            if (! $ok) {
                fwrite(STDERR, "  encode failed: $out\n");
                continue;
            }

            $after += filesize($out);
            $made++;
            printf("    %-5s %5dw  %7.1f KB\n", $fmt, $w, filesize($out) / 1024);
        }
    }
}

printf(
    "\n%d derivatives written, %d already current.\nOriginals %.2f MB — kept as fallback.\nDerivatives total %.2f MB across all widths.\n",
    $made,
    $skipped,
    $before / 1048576,
    $after / 1048576
);
