<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Renders an <img>, upgraded to a <picture> with AVIF and WebP sources when
 * pre-generated derivatives exist beside the original.
 *
 * Derivatives are produced by tools/optimise-images.php and named
 * <stem>-<width>.<avif|webp>. Uploaded photos have none, so they fall through
 * to a plain <img> — the component is safe to use for every image on the site.
 */
class ResponsiveImg extends Component
{
    /** @var array<string, array<int, string>> format => [width => url] */
    public array $sources = [];

    public function __construct(
        public string $src,
        public string $alt = '',
        public ?string $sizes = null,
        public ?int $width = null,
        public ?int $height = null,
        public string $loading = 'lazy',
        public ?string $fetchpriority = null,
    ) {
        $this->sources = $this->discoverSources($src);
    }

    /**
     * Find sibling derivatives for a local /images/... asset.
     *
     * @return array<string, array<int, string>>
     */
    private function discoverSources(string $src): array
    {
        // Only static assets this app ships have derivatives; anything served
        // from storage (or another host) is a user upload.
        $path = parse_url($src, PHP_URL_PATH);
        if (! is_string($path) || ! preg_match('#^/?(images/.+)\.(jpe?g|png)$#i', ltrim($path, '/'), $m)) {
            return [];
        }

        $relStem = $m[1];
        $found = [];

        foreach (['avif', 'webp'] as $fmt) {
            $matches = glob(public_path($relStem).'-*.'.$fmt) ?: [];

            foreach ($matches as $file) {
                if (preg_match('/-(\d+)\.'.$fmt.'$/', $file, $w)) {
                    $found[$fmt][(int) $w[1]] = asset($relStem.'-'.$w[1].'.'.$fmt);
                }
            }

            if (isset($found[$fmt])) {
                ksort($found[$fmt]);
            }
        }

        return $found;
    }

    /**
     * CSS for a background image, upgraded to image-set() when derivatives exist.
     *
     * Emits a plain url() first so browsers without image-set() still paint,
     * then the image-set() declaration overrides it where supported. Uploaded
     * hero slides have no derivatives and get the plain declaration only.
     */
    public static function backgroundCss(string $src): string
    {
        $plain = sprintf("background-image:url('%s');", $src);

        $sources = (new self($src))->sources;
        if (! $sources) {
            return $plain;
        }

        $parts = [];

        foreach (['avif', 'webp'] as $fmt) {
            if (! empty($sources[$fmt])) {
                $widest = end($sources[$fmt]);
                $parts[] = sprintf("url('%s') type('image/%s')", $widest, $fmt);
            }
        }

        $parts[] = sprintf("url('%s')", $src);

        return $plain.sprintf('background-image:image-set(%s);', implode(', ', $parts));
    }

    /** Build a srcset string for one format. */
    public function srcset(string $format): string
    {
        return collect($this->sources[$format] ?? [])
            ->map(fn (string $url, int $w) => $url.' '.$w.'w')
            ->implode(', ');
    }

    public function render(): View
    {
        return view('components.responsive-img');
    }
}
