<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VETech - DVS Sandakan System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js for modal and interactive components -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Mobile Sidebar Backdrop -->
        <div id="sidebarBackdrop" class="hidden fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden" onclick="toggleSidebar()"></div>
        
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out w-64 bg-[#c1e8f7] text-gray-800 flex flex-col z-30 md:z-auto shadow-xl">
            <!-- Logo Section -->
            <div class="p-6 border-b border-[#8fd3e6]">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center mb-1">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                                <i class="fas fa-paw text-white text-xl"></i>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-800">VETech</h1>
                        </div>
                        <p class="text-sm text-gray-600 ml-[52px]">DVS Sandakan</p>
                    </div>
                    <button class="md:hidden text-gray-700 hover:text-gray-900 transition-colors" onclick="toggleSidebar()">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="mt-2 flex-1 px-3 py-4 overflow-y-auto">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 group
                   {{ request()->routeIs('dashboard') 
                       ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' 
                       : 'text-gray-700 hover:bg-[#8fd3e6] hover:text-gray-900' }}">
                    <i class="fas fa-gauge w-5 text-center mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-blue-500' }}"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                @if(auth()->user() && auth()->user()->isCollaborator())
                    <!-- Collaborator Menu -->
                    <div class="mt-6 mb-3 px-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Collaborator Tools</p>
                    </div>
                    
                    <a href="{{ route('collaborator.scanner') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 group
                       {{ request()->routeIs('collaborator.scanner') || request()->routeIs('collaborator.scan') 
                           ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' 
                           : 'text-gray-700 hover:bg-[#8fd3e6] hover:text-gray-900' }}">
                        <i class="fas fa-qrcode w-5 text-center mr-3 {{ request()->routeIs('collaborator.scanner') || request()->routeIs('collaborator.scan') ? 'text-white' : 'text-green-500' }}"></i>
                        <span class="font-medium">Scan Pet Tag</span>
                    </a>
                    
                    <a href="{{ route('collaborator.treatments.index') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 group
                       {{ request()->routeIs('collaborator.treatments.index') || request()->routeIs('collaborator.treatments.create') || request()->routeIs('collaborator.treatments.show') || request()->routeIs('collaborator.treatments.edit')
                           ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' 
                           : 'text-gray-700 hover:bg-[#8fd3e6] hover:text-gray-900' }}">
                        <i class="fas fa-clipboard-list w-5 text-center mr-3 {{ request()->routeIs('collaborator.treatments.index') || request()->routeIs('collaborator.treatments.create') || request()->routeIs('collaborator.treatments.show') || request()->routeIs('collaborator.treatments.edit') ? 'text-white' : 'text-purple-500' }}"></i>
                        <span class="font-medium">My Treatments</span>
                    </a>
                    
                    <a href="{{ route('collaborator.treatments.deleted-log') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 group
                       {{ request()->routeIs('collaborator.treatments.deleted-log') 
                           ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' 
                           : 'text-gray-700 hover:bg-[#8fd3e6] hover:text-gray-900' }}">
                        <i class="fas fa-trash-alt w-5 text-center mr-3 {{ request()->routeIs('collaborator.treatments.deleted-log') ? 'text-white' : 'text-red-500' }}"></i>
                        <span class="font-medium">Deleted Log</span>
                    </a>
                @else
                    <!-- Admin Menu -->
                    <div class="mt-6 mb-3 px-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Management</p>
                    </div>
                    
                    <a href="{{ route('bookings.index') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 group
                       {{ request()->routeIs('bookings.*') 
                           ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' 
                           : 'text-gray-700 hover:bg-[#8fd3e6] hover:text-gray-900' }}">
                        <i class="fas fa-calendar-check w-5 text-center mr-3 {{ request()->routeIs('bookings.*') ? 'text-white' : 'text-blue-500' }}"></i>
                        <span class="font-medium">Bookings</span>
                    </a>
                    
                    <a href="{{ route('customers.index') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 group
                       {{ request()->routeIs('customers.*') 
                           ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' 
                           : 'text-gray-700 hover:bg-[#8fd3e6] hover:text-gray-900' }}">
                        <i class="fas fa-users w-5 text-center mr-3 {{ request()->routeIs('customers.*') ? 'text-white' : 'text-purple-500' }}"></i>
                        <span class="font-medium">Customers & Pets</span>
                    </a>
                    
                    <a href="{{ route('tags.index') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 group
                       {{ request()->routeIs('tags.*') 
                           ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' 
                           : 'text-gray-700 hover:bg-[#8fd3e6] hover:text-gray-900' }}">
                        <i class="fas fa-qrcode w-5 text-center mr-3 {{ request()->routeIs('tags.*') ? 'text-white' : 'text-green-500' }}"></i>
                        <span class="font-medium">Tags & QR Codes</span>
                    </a>
                    
                    @if(auth()->user() && auth()->user()->isAdmin())
                    <a href="{{ route('collaborators.index') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all duration-200 group
                       {{ request()->routeIs('collaborators.*') 
                           ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' 
                           : 'text-gray-700 hover:bg-[#8fd3e6] hover:text-gray-900' }}">
                        <i class="fas fa-handshake w-5 text-center mr-3 {{ request()->routeIs('collaborators.*') ? 'text-white' : 'text-amber-500' }}"></i>
                        <span class="font-medium">Collaborators</span>
                    </a>
                    @endif
                @endif
            </nav>

            <!-- User Info Footer -->
            <div class="p-4 border-t border-[#8fd3e6] bg-[#a8dff0]">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3 shadow-lg">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-600">
                            {{ auth()->user()->isAdmin() ? 'Administrator' : 'Collaborator' }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-4 md:px-6 py-4">
                    <button class="md:hidden text-blue-600 text-xl" onclick="toggleSidebar()">
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
                                <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium text-sm md:text-base">
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
