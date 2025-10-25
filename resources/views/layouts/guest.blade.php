<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VETech') }}</title>

    <!-- TailwindCSS & Fonts via CDN (no Vite required) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for small interactivity used by Breeze components -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-[#550000] min-h-screen">
        <div class="min-h-screen flex flex-col items-center justify-center px-4">
            <!-- Brand -->
            <a href="/" class="block">
                <x-application-logo class="text-white text-3xl md:text-4xl" />
            </a>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md mt-6 bg-white rounded-2xl shadow-2xl ring-1 ring-[#550000]/10">
                <div class="px-7 py-6">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <p class="mt-6 text-xs text-white/80">© {{ date('Y') }} VETech. All rights reserved.</p>
        </div>
    </body>
</html>
