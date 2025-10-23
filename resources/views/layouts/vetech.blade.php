<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VETech - Sandakan Veterinar System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white hidden md:flex md:flex-col">
            <div class="p-4 border-b border-blue-800">
                <h1 class="text-2xl font-bold">VETech</h1>
                <p class="text-sm text-blue-200">Sandakan Veterinar</p>
            </div>

            <nav class="mt-4 flex-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('dashboard') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-gauge mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('customers.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('customers.*') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-users mr-3"></i>
                    Customers & Pets
                </a>
                @if(auth()->user() && auth()->user()->isAdmin())
                <a href="{{ route('collaborators.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('collaborators.*') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-handshake mr-3"></i>
                    Collaborators
                </a>
                @endif
                <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('bookings.*') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-calendar-check mr-3"></i>
                    Bookings
                </a>
                <a href="{{ route('tags.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('tags.*') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-qrcode mr-3"></i>
                    Tags & QR Codes
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-4 md:px-6 py-4">
                    <button class="md:hidden text-blue-900" onclick="document.querySelector('aside').classList.toggle('hidden')">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                    <div class="flex items-center space-x-3">
                        @auth
                            <span class="hidden sm:inline text-gray-700">{{ auth()->user()->name }}</span>
                            <span class="hidden sm:inline px-2 py-1 text-xs rounded-full {{ auth()->user()->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst(auth()->user()->role ?? 'admin') }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-arrow-right-from-bracket"></i> Logout
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
