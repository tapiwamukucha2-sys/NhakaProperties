<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Shared image-upload handling.
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
    /**
     * Store one uploaded image and return its path.
     *
     * @throws ValidationException when the file cannot be written
     */
    protected function storeUploadedImage(UploadedFile $file, string $directory, string $field): string
    {
        try {
            $path = $file->store($directory, 'public');
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
