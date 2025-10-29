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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for small interactivity used by Breeze components -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-[#c1eaf7] via-[#a8dff0] to-[#8fd3e6] min-h-screen">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
            <!-- Brand with Modern Icon -->
            <!--<div class="text-center mb-8">-->
            <!--    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-2">VETech</h1>-->
            <!--    <p class="text-gray-600 text-sm md:text-base">DVS Sandakan Veterinary System</p>-->
            <!--</div>-->

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="px-8 py-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-700 mb-2">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Secure & Reliable Veterinary Management
                </p>
                <p class="text-xs text-gray-600">© {{ date('Y') }} VETech. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
