@extends('layouts.vetech')

@section('title', 'Booking Details - VETech')
@section('header', 'Booking Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('bookings.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
        <i class="fas fa-arrow-left mr-2"></i>Back to Bookings
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Booking Overview - Left Column -->
    <div class="lg:col-span-1">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl shadow-lg p-8 sticky top-6">
            <div class="flex justify-center mb-4">
                <div class="bg-white p-6 rounded-2xl shadow-md">
                    @if($booking->status == 'pending')
                    <div class="w-64 h-64 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-hourglass text-white text-6xl"></i>
                    </div>
                    @elseif($booking->status == 'confirmed')
                    <div class="w-64 h-64 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-white text-6xl"></i>
                    </div>
                    @elseif($booking->status == 'completed')
                    <div class="w-64 h-64 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-circle-check text-white text-6xl"></i>
                    </div>
                    @else
                    <div class="w-64 h-64 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-xmark text-white text-6xl"></i>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center bg-white px-6 py-3 rounded-full shadow-md mb-3">
                    <i class="fas fa-hashtag text-blue-600 mr-3 text-xl"></i>
                    <span class="font-mono text-2xl font-bold text-gray-800">{{ $booking->queue_number }}</span>
                </div>
                <p class="text-sm text-gray-600">
                    <i class="fas fa-clock mr-1"></i>Queue Position
                </p>
            </div> -->

            <!-- Quick Status Update -->
            <form id="updateStatusForm" action="{{ route('bookings.updateStatus', $booking) }}" method="POST" class="mb-4">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                    <select id="statusSelect" name="status" class="w-full rounded-md border-gray-300 shadow-sm p-2 border text-sm">
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <input type="hidden" name="reason" id="cancelReasonInput" value="">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    <i class="fas fa-save mr-1"></i>
                    Update Status
                </button>
            </form>
        </div>
    </div>

    <!-- Booking Information - Right Column -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header with Status -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-calendar-check mr-3"></i>Booking Information
                    </h3>
                    <span class="px-4 py-2 text-sm font-semibold rounded-full 
                        @if($booking->status == 'pending') bg-yellow-500 text-white
                        @elseif($booking->status == 'confirmed') bg-blue-500 text-white
                        @elseif($booking->status == 'completed') bg-green-500 text-white
                        @else bg-red-500 text-white
                        @endif">
                        <i class="fas fa-circle mr-1 text-xs"></i>{{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Booking Details -->
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-6 border border-blue-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-alt text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-700">Appointment Details</h4>
                        </div>
                        <p class="text-xl font-bold text-blue-700 mb-1">{{ $booking->booking_date->format('d M Y') }}</p>
                        <p class="text-sm text-gray-600 mb-2">{{ date('H:i', strtotime($booking->booking_time)) }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->service_type }}</p>
                    </div>

                    <!-- Customer Information -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-700">Customer Details</h4>
                        </div>
                        <a href="{{ route('customers.show', $booking->customer) }}" 
                           class="block text-xl font-bold text-purple-700 hover:text-purple-900 mb-2">
                            {{ $booking->customer->name }}
                        </a>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-id-card mr-1"></i>{{ $booking->customer->ic_number }}
                        </p>
                        @if($booking->customer->phone)
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-phone mr-1"></i>{{ $booking->customer->phone }}
                        </p>
                        @endif
                    </div>

                    <!-- Pet Information -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-paw text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-700">Pet Details</h4>
                        </div>
                        <a href="{{ route('customers.pets.show', [$booking->customer, $booking->pet]) }}" 
                           class="block text-xl font-bold text-green-700 hover:text-green-900 mb-2">
                            {{ $booking->pet->name }}
                        </a>
                        <p class="text-sm text-gray-600">{{ $booking->pet->species ?? 'Pet' }}</p>
                        @if($booking->pet->breed)
                        <p class="text-sm text-gray-600">{{ $booking->pet->breed }}</p>
                        @endif
                    </div>

                    <!-- Timeline -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-700">Timeline</h4>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Created</p>
                                    <p class="text-xs text-gray-500">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            @if($booking->updated_at != $booking->created_at)
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Updated</p>
                                    <p class="text-xs text-gray-500">{{ $booking->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                @if($booking->reason || $booking->notes)
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-gray-500 mr-2"></i>
                        Additional Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($booking->reason)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h5 class="font-medium text-gray-700 mb-2">Reason for Visit</h5>
                            <p class="text-gray-600">{{ $booking->reason }}</p>
                        </div>
                        @endif
                        @if($booking->notes)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h5 class="font-medium text-gray-700 mb-2">Notes</h5>
                            <p class="text-gray-600">{{ $booking->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Cancellation Reason Modal -->
<div id="cancelReasonModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-ban text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4 text-center">Cancellation Reason</h3>
            <div class="mt-2">
                <label for="cancelReasonText" class="block text-sm font-medium text-gray-700 mb-1">Please provide a reason before cancelling</label>
                <textarea id="cancelReasonText" rows="4" class="w-full border rounded-md p-2 text-sm border-gray-300" placeholder="Enter cancellation reason..."></textarea>
                <p id="cancelReasonError" class="hidden text-xs text-red-600 mt-1">Reason is required.</p>
            </div>
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" id="cancelReasonCloseBtn" class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">Cancel</button>
                <button type="button" id="cancelReasonConfirmBtn" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">Confirm & Update</button>
            </div>
        </div>
    </div>
    
    <script>
    (function() {
        var statusSelect = document.getElementById('statusSelect');
        var form = document.getElementById('updateStatusForm');
        var modal = document.getElementById('cancelReasonModal');
        var reasonInput = document.getElementById('cancelReasonInput');
        var reasonText = document.getElementById('cancelReasonText');
        var reasonError = document.getElementById('cancelReasonError');
        var confirmBtn = document.getElementById('cancelReasonConfirmBtn');
        var closeBtn = document.getElementById('cancelReasonCloseBtn');

        function openModal() {
            modal.classList.remove('hidden');
            reasonText.focus();
        }

        function closeModal() {
            modal.classList.add('hidden');
            reasonError.classList.add('hidden');
        }

        function isCancelledSelected() {
            return statusSelect && statusSelect.value === 'cancelled';
        }

        if (statusSelect) {
            statusSelect.addEventListener('change', function() {
                if (isCancelledSelected()) {
                    if (!reasonInput.value) {
                        openModal();
                    }
                } else {
                    // Clear reason if switching away from cancelled
                    reasonInput.value = '';
                }
            });
        }

        if (form) {
            form.addEventListener('submit', function(e) {
                if (isCancelledSelected() && !reasonInput.value) {
                    e.preventDefault();
                    openModal();
                }
            });
        }

        if (confirmBtn) {
            confirmBtn.addEventListener('click', function() {
                var value = (reasonText.value || '').trim();
                if (!value) {
                    reasonError.classList.remove('hidden');
                    reasonText.focus();
                    return;
                }
                reasonError.classList.add('hidden');
                reasonInput.value = value;
                closeModal();
                if (form) {
                    form.submit();
                }
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                closeModal();
                // If user cancels modal, also reset select away from cancelled for clarity
                if (isCancelledSelected()) {
                    statusSelect.value = '{{ $booking->status }}';
                }
            });
        }
    })();
    </script>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Delete Booking</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete this booking (#{{ $booking->queue_number }})?
                    This booking is for <strong>{{ $booking->pet->name }}</strong> owned by <strong>{{ $booking->customer->name }}</strong>.
                    This action cannot be undone.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Delete
                    </button>
                </form>
                <button onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="ml-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection