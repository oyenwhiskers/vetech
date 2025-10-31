@extends('layouts.vetech')

@section('title', 'Bookings - VETech')
@section('header', 'Manage Bookings')

@section('content')
<div class="mb-6">
    <div>
        <h3 class="text-lg font-semibold">Booking Management</h3>
        <p class="text-sm text-gray-600">Manage appointments and queue</p>
    </div>
</div>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
    <!-- Total Bookings -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-4 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90">Total Bookings</p>
                <p class="text-3xl font-bold mt-1">{{ $totalBookings }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-clipboard-list text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Today's Bookings -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-4 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90">Today</p>
                <p class="text-3xl font-bold mt-1">{{ $todayBookings }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-calendar-alt text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending -->
    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-4 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90">Pending</p>
                <p class="text-3xl font-bold mt-1">{{ $pendingBookings }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-hourglass-half text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Confirmed -->
    <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl shadow-lg p-4 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90">Confirmed</p>
                <p class="text-3xl font-bold mt-1">{{ $confirmedBookings }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Completed -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-4 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90">Completed</p>
                <p class="text-3xl font-bold mt-1">{{ $completedBookings }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Cancelled -->
    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-4 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90">Cancelled</p>
                <p class="text-3xl font-bold mt-1">{{ $cancelledBookings }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-ban text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Set Customer Appointment Button -->
<div class="flex justify-end mb-4">
    <a href="{{ route('bookings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i>Set Customer Appointment
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
                <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Queue</th> -->
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($bookings as $booking)
            <tr>
                <!-- <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-200">
                        #{{ $booking->queue_number }}
                    </span>
                </td> -->
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if($booking->booking_by !== null)
                    <div class="text-blue-600">Appointment</div>
                    @endif
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
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                    <a href="{{ route('bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-900">
                        <i class="fas fa-eye"></i>
                    </a>
                    @if($booking->booking_by == Auth::user()->id)
                    <a href="{{ route('bookings.edit', $booking) }}" class="text-yellow-600 hover:text-yellow-900 ml-2">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" data-booking-id="{{ $booking->id }}" class="js-delete-booking text-red-600 hover:text-red-900 ml-2">
                        <i class="fas fa-trash"></i>
                    </button>
                    @endif
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

<form id="delete-booking-form" method="POST" action="#" class="hidden">
    @csrf
    @method('DELETE')
</form>
<script>
document.addEventListener('click', function (e) {
    var target = e.target.closest('.js-delete-booking');
    if (!target) return;
    var bookingId = target.getAttribute('data-booking-id');
    if (!bookingId) return;
    if (!confirm('Delete this booking? This action cannot be undone.')) return;
    var form = document.getElementById('delete-booking-form');
    form.action = "{{ url('bookings') }}" + '/' + bookingId;
    form.submit();
});
</script>

<div class="mt-6">
    {{ $bookings->links() }}
</div>
@endsection
