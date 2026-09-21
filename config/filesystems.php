<?php

/*
| Cloudflare R2 (S3-compatible). Defined up front so the disk list can both
| expose it by name and decide whether it is safe to use as the public disk.
|
| 'throw' and 'report' are deliberately on: a storage failure must surface in
| the logs and abort the request. With them off, Storage::put()/store() returns
| false on failure, and callers happily persist that false as a file path.
*/
$r2 = [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'auto'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', true),
    'visibility' => 'public',
    'throw' => true,
    'report' => true,
];

// Every credential must be present, not just the FILESYSTEM_DISK switch.
$r2Configured = env('FILESYSTEM_DISK') === 'r2'
    && filled(env('AWS_ACCESS_KEY_ID'))
    && filled(env('AWS_SECRET_ACCESS_KEY'))
    && filled(env('AWS_BUCKET'))
    && filled(env('AWS_ENDPOINT'));

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    /*
     | NOTE: deployments set FILESYSTEM_DISK=r2. That value selects the cloud
     | branch of the 'public' disk below AND names the default disk, so an 'r2'
     | disk has to exist in the list or every default-disk call would fail with
     | "Disk [r2] does not have a configured driver".
     */
    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        /*
         | The public disk is R2 only when R2 is genuinely configured. Selecting
         | the cloud branch on FILESYSTEM_DISK alone meant that a missing bucket
         | or key produced an S3 client pointed at nothing: uploads then failed
         | and, because 'throw' was off, store() returned false and that false
         | was saved as the image path. Falling back to local keeps uploads
         | working (until the next redeploy) instead of writing broken records.
         */
        'public' => $r2Configured ? $r2 : [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
            'visibility' => 'public',
            'throw' => true,
            'report' => true,
        ],

        // Addressable by name, so Storage::disk('r2') and a default of 'r2' both resolve.
        'r2' => $r2,

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => true,
            'report' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
