<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageStorageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Re-evaluate config/filesystems.php with a given environment.
     *
     * @param  array<string, string|null>  $env
     * @return array<string, mixed>
     */
    private function filesystemsConfigWith(array $env): array
    {
        $original = [];

        foreach ($env as $key => $value) {
            $original[$key] = getenv($key) === false ? null : getenv($key);

            if ($value === null) {
                putenv($key);
                unset($_ENV[$key], $_SERVER[$key]);
            } else {
                putenv("$key=$value");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }

        try {
            return require config_path('filesystems.php');
        } finally {
            foreach ($original as $key => $value) {
                if ($value === null) {
                    putenv($key);
                    unset($_ENV[$key], $_SERVER[$key]);
                } else {
                    putenv("$key=$value");
                    $_ENV[$key] = $value;
                    $_SERVER[$key] = $value;
                }
            }
        }
    }

    public function test_public_disk_uses_r2_when_it_is_fully_configured(): void
    {
        $config = $this->filesystemsConfigWith([
            'FILESYSTEM_DISK' => 'r2',
            'AWS_ACCESS_KEY_ID' => 'key',
            'AWS_SECRET_ACCESS_KEY' => 'secret',
            'AWS_BUCKET' => 'nhaka',
            'AWS_ENDPOINT' => 'https://example.r2.cloudflarestorage.com',
        ]);

        $this->assertSame('s3', $config['disks']['public']['driver']);
        $this->assertSame('nhaka', $config['disks']['public']['bucket']);
    }

    /**
     * The bug this guards: FILESYSTEM_DISK=r2 alone used to select an S3 client
     * pointed at a null bucket. Uploads then failed and, with 'throw' disabled,
     * store() returned false which callers persisted as the image path.
     */
    public function test_public_disk_falls_back_to_local_when_r2_credentials_are_missing(): void
    {
        $config = $this->filesystemsConfigWith([
            'FILESYSTEM_DISK' => 'r2',
            'AWS_ACCESS_KEY_ID' => null,
            'AWS_SECRET_ACCESS_KEY' => null,
            'AWS_BUCKET' => null,
            'AWS_ENDPOINT' => null,
        ]);

        $this->assertSame('local', $config['disks']['public']['driver']);
    }

    public function test_an_r2_disk_exists_so_a_default_of_r2_resolves(): void
    {
        $config = $this->filesystemsConfigWith(['FILESYSTEM_DISK' => 'r2']);

        // 'default' => env('FILESYSTEM_DISK') would otherwise name a disk that
        // does not exist, and every default-disk call would throw.
        $this->assertSame('r2', $config['default']);
        $this->assertArrayHasKey('r2', $config['disks']);
    }

    public function test_storage_failures_are_never_swallowed(): void
    {
        $config = $this->filesystemsConfigWith([
            'FILESYSTEM_DISK' => 'r2',
            'AWS_ACCESS_KEY_ID' => 'key',
            'AWS_SECRET_ACCESS_KEY' => 'secret',
            'AWS_BUCKET' => 'nhaka',
            'AWS_ENDPOINT' => 'https://example.r2.cloudflarestorage.com',
        ]);

        foreach (['public', 'r2', 's3'] as $disk) {
            $this->assertTrue($config['disks'][$disk]['throw'], "$disk should throw on failure");
            $this->assertTrue($config['disks'][$disk]['report'], "$disk should report failures");
        }
    }

    public function test_uploaded_avatar_is_stored_and_path_recorded(): void
    {
        Storage::fake('public');

        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->post(route('profile.avatar'), [
            'avatar' => UploadedFile::fake()->image('me.jpg'),
        ]);

        $response->assertSessionHasNoErrors();

        $user->refresh();

        $this->assertIsString($user->avatar_path);
        $this->assertNotSame('', $user->avatar_path);
        Storage::disk('public')->assertExists($user->avatar_path);
    }
}
