@extends('layouts.vetech')

@section('title', 'Dashboard - VETech')
@section('header', 'Dashboard')

@section('content')
<!-- Quick Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Total Customers -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Total Customers</p>
                <p class="text-3xl font-bold">{{ $totalCustomers }}</p>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <i class="fas fa-users text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Pets -->
    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium mb-1">Total Pets</p>
                <p class="text-3xl font-bold">{{ $totalPets }}</p>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <i class="fas fa-paw text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Active Collaborators -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium mb-1">Active Collaborators</p>
                <p class="text-3xl font-bold">{{ $totalCollaborators }}</p>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <i class="fas fa-handshake text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Today's Bookings -->
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium mb-1">Today's Bookings</p>
                <p class="text-3xl font-bold">{{ $todayBookings }}</p>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <i class="fas fa-calendar-check text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Total Treatments -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-500 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Treatments</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalTreatments }}</p>
            </div>
            <i class="fas fa-notes-medical text-3xl text-indigo-500"></i>
        </div>
    </div>

    <!-- Pending Bookings -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Pending Bookings</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pendingBookings }}</p>
            </div>
            <i class="fas fa-clock text-3xl text-yellow-500"></i>
        </div>
    </div>

    <!-- Total Tags -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total QR Tags</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalTags }}</p>
            </div>
            <i class="fas fa-qrcode text-3xl text-green-500"></i>
        </div>
    </div>

    <!-- Unassigned Tags -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-amber-500 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Unassigned Tags</p>
                <p class="text-2xl font-bold text-gray-800">{{ $unassignedTags }}</p>
            </div>
            <i class="fas fa-tag text-3xl text-amber-500"></i>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Booking Status Breakdown -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
            Booking Status Distribution
        </h3>
        <div class="space-y-3">
            @foreach($bookingStatusStats as $stat)
                @php
                    try {
                        $bookingTotal = \App\Models\Booking::count();
                        $percentage = $bookingTotal > 0 ? ($stat->count / $bookingTotal * 100) : 0;
                    } catch (\Throwable $e) {
                        $percentage = 0;
                        echo '<div style="background:#fee2e2;color:#991b1b;padding:10px;border-radius:8px;margin-bottom:10px;">
                                <strong>Debug:</strong> ' . e($e->getMessage()) . '
                              </div>';
                    }
                    $colors = [
                        'pending' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-700'],
                        'confirmed' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-700'],
                        'completed' => ['bg' => 'bg-green-500', 'text' => 'text-green-700'],
                        'cancelled' => ['bg' => 'bg-red-500', 'text' => 'text-red-700'],
                    ];
                    $color = $colors[$stat->status] ?? ['bg' => 'bg-gray-500', 'text' => 'text-gray-700'];
                @endphp
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-700 capitalize">{{ $stat->status }}</span>
                        <span class="text-sm font-bold {{ $color['text'] }}">{{ $stat->count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="{{ $color['bg'] }} h-2 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Pet Species Distribution -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-paw text-purple-500 mr-2"></i>
            Pet Species Distribution
        </h3>
        <div class="space-y-3">
            @foreach($speciesStats->take(5) as $species)
                @php
                    $percentage = $totalPets > 0 ? ($species->count / $totalPets * 100) : 0;
                    $colors = ['bg-purple-500', 'bg-pink-500', 'bg-indigo-500', 'bg-blue-500', 'bg-cyan-500'];
                    $colorIndex = $loop->index % count($colors);
                @endphp
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-700">{{ $species->species ?? 'Unknown' }}</span>
                        <span class="text-sm font-bold text-gray-700">{{ $species->count }} ({{ number_format($percentage, 1) }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="{{ $colors[$colorIndex] }} h-2 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Top Collaborators & Monthly Trends -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Top Collaborators -->
    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl shadow-lg p-6 border border-indigo-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-trophy text-amber-500 mr-2"></i>
            Top Collaborators (Last 3 Months)
        </h3>
        <div class="space-y-3">
            @forelse($topCollaborators as $collab)
                <div class="flex items-center justify-between bg-white rounded-lg p-3 shadow-sm">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                            {{ $loop->iteration }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $collab->name }}</p>
                            <p class="text-xs text-gray-500">{{ $collab->treatment_count }} treatments</p>
                        </div>
                    </div>
                    <i class="fas fa-star text-amber-400 text-xl"></i>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No data available</p>
            @endforelse
        </div>
    </div>

    <!-- Monthly Booking Trends -->
    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl shadow-lg p-6 border border-blue-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-chart-line text-blue-500 mr-2"></i>
            Monthly Booking Trends
        </h3>
        <div class="space-y-2">
            @php
                $maxBookings = $monthlyBookings->max('count') ?? 1;
            @endphp
            @forelse($monthlyBookings as $month)
                @php
                    $percentage = ($month->count / $maxBookings) * 100;
                    $date = \Carbon\Carbon::parse($month->month . '-01');
                @endphp
                <div class="flex items-center">
                    <span class="text-sm font-medium text-gray-700 w-20">{{ $date->format('M Y') }}</span>
                    <div class="flex-1 mx-3">
                        <div class="w-full bg-gray-200 rounded-full h-6">
                            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-6 rounded-full flex items-center justify-end pr-2 transition-all" style="width: {{ $percentage }}%">
                                <span class="text-xs font-bold text-white">{{ $month->count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No data available</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Bookings -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
            <h3 class="text-lg font-bold text-white flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i>
                Recent Bookings
            </h3>
        </div>
        <div class="p-6">
            @forelse($recentBookings as $booking)
                <div class="flex items-start justify-between border-b border-gray-200 pb-4 mb-4 last:border-0 last:mb-0 last:pb-0">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">{{ $booking->customer->name }}</p>
                        <p class="text-sm text-gray-600 flex items-center mt-1">
                            <i class="fas fa-paw text-purple-500 mr-1"></i>
                            Pet: {{ $booking->pet->name }}
                        </p>
                        <p class="text-xs text-gray-500 flex items-center mt-1">
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $booking->booking_date->format('d M Y') }} - {{ $booking->booking_time }}
                        </p>
                    </div>
                    <span class="px-3 py-1 text-xs font-bold rounded-full whitespace-nowrap ml-3
                        @if($booking->status == 'pending') bg-yellow-100 text-yellow-700
                        @elseif($booking->status == 'confirmed') bg-blue-100 text-blue-700
                        @elseif($booking->status == 'completed') bg-green-100 text-green-700
                        @else bg-red-100 text-red-700
                        @endif">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-sm text-center py-4">No recent bookings</p>
            @endforelse
            
            @if($recentBookings->count() > 0)
                <div class="mt-4 text-center">
                    <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        View all bookings →
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Treatments -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
            <h3 class="text-lg font-bold text-white flex items-center">
                <i class="fas fa-notes-medical mr-2"></i>
                Recent Treatments
            </h3>
        </div>
        <div class="p-6">
            @forelse($recentTreatments as $treatment)
                <div class="border-b border-gray-200 pb-4 mb-4 last:border-0 last:mb-0 last:pb-0">
                    <div class="flex items-start justify-between mb-2">
                        <p class="font-semibold text-gray-800">{{ $treatment->pet->name }}</p>
                        <span class="text-xs text-gray-500">{{ $treatment->treatment_date->format('d M Y') }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-1">{{ Str::limit($treatment->diagnosis, 60) }}</p>
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span class="flex items-center">
                            <i class="fas fa-user text-blue-500 mr-1"></i>
                            Owner: {{ $treatment->pet->customer->name }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-user-md text-purple-500 mr-1"></i>
                            By {{ $treatment->user->name }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm text-center py-4">No recent treatments</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
