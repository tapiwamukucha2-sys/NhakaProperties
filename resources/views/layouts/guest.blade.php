<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[--paper]">
            <div>
                <a href="/" class="flex items-center gap-2 font-serif-brand text-2xl font-bold text-[--ink]">
                    <x-logo :size="40" />
                    {{ config('app.name') }}
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-[--paper-2] shadow-md overflow-hidden sm:rounded-lg border border-[--line]">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
