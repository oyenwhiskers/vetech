@extends('layouts.vetech')

@section('title', 'Bookings - VETech')
@section('header', 'Manage Bookings')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-lg font-semibold">Booking Management</h3>
        <p class="text-sm text-gray-600">Manage appointments and queue</p>
    </div>
    <a href="{{ route('bookings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i>New Booking
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" action="{{ route('bookings.index') }}" class="flex gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="rounded-md border-gray-300 shadow-sm p-2 border">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
            <input type="date" name="date" value="{{ request('date') }}"
                class="rounded-md border-gray-300 shadow-sm p-2 border">
        </div>
        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Filter
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Queue</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($bookings as $booking)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-200">
                        #{{ $booking->queue_number }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <div>{{ $booking->booking_date->format('d M Y') }}</div>
                    <div class="text-gray-600">{{ date('H:i', strtotime($booking->booking_time)) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $booking->customer->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $booking->pet->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $booking->service_type }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($booking->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($booking->status == 'confirmed') bg-blue-100 text-blue-800
                        @elseif($booking->status == 'completed') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($booking->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('bookings.edit', $booking) }}" class="text-yellow-600 hover:text-yellow-900">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No bookings found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $bookings->links() }}
</div>
@endsection
