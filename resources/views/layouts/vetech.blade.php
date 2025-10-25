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
        <!-- Mobile Sidebar Backdrop -->
        <div id="sidebarBackdrop" class="hidden fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden" onclick="toggleSidebar()"></div>
        
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out w-64 bg-[#550000] text-white flex flex-col z-30 md:z-auto">
            <div class="p-4 border-b border-[#3a0000] flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">VETech</h1>
                    <p class="text-sm text-white/70">Sandakan Veterinar</p>
                </div>
                <button class="md:hidden text-white" onclick="toggleSidebar()">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <nav class="mt-4 flex-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 hover:bg-[#3a0000] {{ request()->routeIs('dashboard') ? 'bg-[#3a0000]' : '' }}">
                    <i class="fas fa-gauge mr-3"></i>
                    Dashboard
                </a>
                
                @if(auth()->user() && auth()->user()->isCollaborator())
                    <!-- Collaborator Menu -->
                    <a href="{{ route('collaborator.scanner') }}" class="flex items-center px-4 py-3 hover:bg-[#3a0000] {{ request()->routeIs('collaborator.scanner') || request()->routeIs('collaborator.scan') ? 'bg-[#3a0000]' : '' }}">
                        <i class="fas fa-qrcode mr-3"></i>
                        Scan Pet Tag
                    </a>
                    <a href="{{ route('collaborator.treatments.index') }}" class="flex items-center px-4 py-3 hover:bg-[#3a0000] {{ request()->routeIs('collaborator.treatments.*') ? 'bg-[#3a0000]' : '' }}">
                        <i class="fas fa-clipboard-list mr-3"></i>
                        My Treatments
                    </a>
                    <a href="{{ route('collaborator.treatments.deleted-log') }}" class="flex items-center px-4 py-3 hover:bg-[#3a0000] {{ request()->routeIs('collaborator.treatments.deleted-log') ? 'bg-[#3a0000]' : '' }}">
                        <i class="fas fa-trash-alt mr-3"></i>
                        Deleted Log
                    </a>
                @else
                    <!-- Admin Menu -->
                    <a href="{{ route('customers.index') }}" class="flex items-center px-4 py-3 hover:bg-[#3a0000] {{ request()->routeIs('customers.*') ? 'bg-[#3a0000]' : '' }}">
                        <i class="fas fa-users mr-3"></i>
                        Customers & Pets
                    </a>
                    @if(auth()->user() && auth()->user()->isAdmin())
                    <a href="{{ route('collaborators.index') }}" class="flex items-center px-4 py-3 hover:bg-[#3a0000] {{ request()->routeIs('collaborators.*') ? 'bg-[#3a0000]' : '' }}">
                        <i class="fas fa-handshake mr-3"></i>
                        Collaborators
                    </a>
                    @endif
                    <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-3 hover:bg-[#3a0000] {{ request()->routeIs('bookings.*') ? 'bg-[#3a0000]' : '' }}">
                        <i class="fas fa-calendar-check mr-3"></i>
                        Bookings
                    </a>
                    <a href="{{ route('tags.index') }}" class="flex items-center px-4 py-3 hover:bg-[#3a0000] {{ request()->routeIs('tags.*') ? 'bg-[#3a0000]' : '' }}">
                        <i class="fas fa-qrcode mr-3"></i>
                        Tags & QR Codes
                    </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-4 md:px-6 py-4">
                    <button class="md:hidden text-[#550000] text-xl" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-lg sm:text-xl md:text-2xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                    <div class="flex items-center gap-2 sm:gap-3">
                        @auth
                            <span class="hidden sm:inline text-sm md:text-base text-gray-700">{{ auth()->user()->name }}</span>
                            <span class="hidden sm:inline px-2 py-1 text-xs rounded-full {{ auth()->user()->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst(auth()->user()->role ?? 'admin') }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-[#550000] hover:text-[#3a0000] font-medium text-sm md:text-base">
                                    <i class="fas fa-arrow-right-from-bracket"></i>
                                    <span class="hidden sm:inline ml-1">Logout</span>
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 text-sm sm:text-base">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 text-sm sm:text-base">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 text-sm sm:text-base">
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

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
</body>
</html>
