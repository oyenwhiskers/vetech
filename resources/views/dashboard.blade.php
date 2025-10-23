@extends('layouts.vetech')

@section('title', 'Dashboard - VETech')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Stat Cards -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                <i class="fas fa-users text-white text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Customers</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalCustomers }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                <i class="fas fa-paw text-white text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Pets</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalPets }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                <i class="fas fa-handshake text-white text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Active Collaborators</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalCollaborators }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-orange-500 rounded-md p-3">
                <i class="fas fa-calendar-check text-white text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Today's Bookings</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $todayBookings }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Bookings -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Recent Bookings</h3>
        </div>
        <div class="p-6">
            @if($recentBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($recentBookings as $booking)
                        <div class="flex items-center justify-between border-b pb-3">
                            <div>
                                <p class="font-semibold">{{ $booking->customer->name }}</p>
                                <p class="text-sm text-gray-600">Pet: {{ $booking->pet->name }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->booking_date->format('d M Y') }} - {{ $booking->booking_time }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status == 'confirmed') bg-blue-100 text-blue-800
                                @elseif($booking->status == 'completed') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        View all bookings →
                    </a>
                </div>
            @else
                <p class="text-gray-500">No recent bookings</p>
            @endif
        </div>
    </div>

    <!-- Recent Treatments -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Recent Treatments</h3>
        </div>
        <div class="p-6">
            @if($recentTreatments->count() > 0)
                <div class="space-y-4">
                    @foreach($recentTreatments as $treatment)
                        <div class="border-b pb-3">
                            <p class="font-semibold">{{ $treatment->pet->name }} ({{ $treatment->pet->customer->name }})</p>
                            <p class="text-sm text-gray-600">{{ Str::limit($treatment->diagnosis, 50) }}</p>
                            <p class="text-xs text-gray-500">By {{ $treatment->user->name }} - {{ $treatment->treatment_date->format('d M Y') }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No recent treatments</p>
            @endif
        </div>
    </div>
</div>
@endsection
