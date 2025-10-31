@extends('layouts.vetech')

@section('title', 'New Booking - VETech')
@section('header', 'Create New Booking')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-100 rounded-2xl shadow-2xl p-8">
        <div class="flex items-center gap-4 mb-8">
            <span class="bg-blue-600 text-white rounded-full flex items-center justify-center w-16 h-16 shadow-lg">
                <i class="fas fa-calendar-plus text-3xl"></i>
            </span>
            <h2 class="text-2xl font-bold text-[#2563eb]">Create Booking</h2>
        </div>

        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-user mr-1 text-blue-600"></i> Customer *</label>
                    <select name="customer_id" id="customer_id" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->ic_number }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-paw mr-1 text-blue-600"></i> Pet *</label>
                    <select name="pet_id" id="pet_id" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                        <option value="">Select Pet</option>
                        @foreach($pets as $pet)
                            <option value="{{ $pet->id }}" data-customer="{{ $pet->customer_id }}" {{ old('pet_id') == $pet->id ? 'selected' : '' }}>
                                {{ $pet->name }} ({{ $pet->species }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-calendar-day mr-1 text-blue-600"></i> Booking Date *</label>
                    <input type="date" name="booking_date" value="{{ old('booking_date', date('Y-m-d')) }}" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-clock mr-1 text-blue-600"></i> Booking Time *</label>
                    <input type="time" name="booking_time" value="{{ old('booking_time', '09:00') }}" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-stethoscope mr-1 text-blue-600"></i> Service *</label>
                <select name="service_type" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                    <option value="">Select Service</option>
                    <option value="Vaccination" {{ old('service_type') == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                    <option value="Checkup" {{ old('service_type') == 'Checkup' ? 'selected' : '' }}>General Checkup</option>
                    <option value="Surgery" {{ old('service_type') == 'Surgery' ? 'selected' : '' }}>Surgery</option>
                    <option value="Dental" {{ old('service_type') == 'Dental' ? 'selected' : '' }}>Dental Care</option>
                    <option value="Grooming" {{ old('service_type') == 'Grooming' ? 'selected' : '' }}>Grooming</option>
                    <option value="Emergency" {{ old('service_type') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                    <option value="Other" {{ old('service_type') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-question-circle mr-1 text-blue-600"></i> Reason</label>
                <textarea name="reason" rows="3"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">{{ old('reason') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-sticky-note mr-1 text-blue-600"></i> Notes</label>
                <textarea name="notes" rows="2"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 mt-2">
                <a href="{{ route('bookings.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="bg-[#334da1] hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-save"></i> Create Booking
                </button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var customerSelect = document.getElementById('customer_id');
    var petSelect = document.getElementById('pet_id');

    function filterPets() {
        var selectedCustomerId = customerSelect.value;
        var hasValidSelection = false;

        Array.prototype.forEach.call(petSelect.options, function (option, index) {
            if (index === 0) {
                // Keep placeholder always visible
                option.hidden = false;
                option.disabled = false;
                return;
            }
            var petCustomerId = option.getAttribute('data-customer');
            var matches = selectedCustomerId && petCustomerId === selectedCustomerId;
            option.hidden = !matches;
            option.disabled = !matches;
            if (matches && option.selected) {
                hasValidSelection = true;
            }
        });

        if (!hasValidSelection) {
            petSelect.value = '';
        }
    }

    customerSelect.addEventListener('change', filterPets);
    // Initialize on load (handles old() values)
    filterPets();
});
</script>
@endsection
