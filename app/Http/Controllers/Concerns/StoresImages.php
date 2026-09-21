<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Shared image-upload handling: re-encode, then store.
 *
 * The 'public' disk is configured with 'throw' => true, so a storage failure
 * (bad R2 credentials, unreachable bucket, full volume) raises rather than
 * returning false. That is deliberate: when it returned false, callers stored
 * the literal false as the image path and produced permanently broken records.
 *
 * These helpers turn that exception into a logged error plus an ordinary
 * validation message, so the user sees the form again instead of a 500.
 */
trait StoresImages
{
    /** Longest edge kept for an uploaded photo. Beyond this is wasted bytes. */
    private static int $maxEdge = 1600;

    /** WebP quality. 82 is visually lossless for photographs at this size. */
    private static int $webpQuality = 82;

    /**
     * Store one uploaded image and return its path.
     *
     * @throws ValidationException when the file cannot be written
     */
    protected function storeUploadedImage(UploadedFile $file, string $directory, string $field): string
    {
        try {
            $path = $this->storeOptimised($file, $directory)
                ?? $file->store($directory, 'public');
        } catch (Throwable $e) {
            $this->failUpload($e, $field, $directory);
        }

        // A disk with 'throw' disabled would hand back false rather than raising.
        if (! is_string($path) || $path === '') {
            $this->failUpload(null, $field, $directory);
        }

        return $path;
    }

    /**
     * Store many uploaded images and return their paths.
     *
     * @param  array<int, UploadedFile>  $files
     * @return array<int, string>
     *
     * @throws ValidationException when any file cannot be written
     */
    protected function storeUploadedImages(array $files, string $directory, string $field): array
    {
        return array_map(
            fn (UploadedFile $file) => $this->storeUploadedImage($file, $directory, $field),
            array_values($files)
        );
    }

    /**
     * Downscale and re-encode to WebP before storing.
     *
     * Returns null when this build of GD cannot do the job (no WebP encoder,
     * or no decoder for the uploaded type), leaving the caller to store the
     * original untouched. Production needs gd built --with-jpeg --with-webp;
     * see the Dockerfile.
     */
    private function storeOptimised(UploadedFile $file, string $directory): ?string
    {
        if (! function_exists('imagewebp') || ! function_exists('imagecreatefromstring')) {
            return null;
        }

        $mime = (string) $file->getMimeType();
        if (! in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return null;
        }

        $raw = @file_get_contents($file->getRealPath());
        if ($raw === false) {
            return null;
        }

        $im = @imagecreatefromstring($raw);
        if ($im === false) {
            return null;
        }

        try {
            $w = imagesx($im);
            $h = imagesy($im);
            $longest = max($w, $h);

            if ($longest > self::$maxEdge) {
                $scale = self::$maxEdge / $longest;
                $nw = max(1, (int) round($w * $scale));
                $nh = max(1, (int) round($h * $scale));

                $resized = imagecreatetruecolor($nw, $nh);
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                imagecopyresampled($resized, $im, 0, 0, 0, 0, $nw, $nh, $w, $h);
                imagedestroy($im);
                $im = $resized;
            }

            ob_start();
            $ok = imagewebp($im, null, self::$webpQuality);
            $binary = (string) ob_get_clean();

            if (! $ok || $binary === '') {
                return null;
            }
        } finally {
            if (is_object($im) || is_resource($im)) {
                imagedestroy($im);
            }
        }

        $path = trim($directory, '/').'/'.Str::random(40).'.webp';

        // Throws on a storage failure; storeUploadedImage() converts that to a
        // validation error rather than letting a false path be persisted.
        Storage::disk('public')->put($path, $binary);

        return $path;
    }

    /**
     * @throws ValidationException
     */
    private function failUpload(?Throwable $e, string $field, string $directory): never
    {
        Log::error('Image upload failed', [
            'directory' => $directory,
            'disk' => config('filesystems.disks.public.driver'),
            'exception' => $e?->getMessage(),
        ]);

        throw ValidationException::withMessages([
            $field => 'We could not save that image. Please try again, and let us know if it keeps happening.',
        ]);
    }
}
