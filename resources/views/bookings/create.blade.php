@extends('layouts.vetech')

@section('title', 'New Booking - VETech')
@section('header', 'Create New Booking')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer *</label>
                    <select name="customer_id" id="customer_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->ic_number }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Pet *</label>
                    <select name="pet_id" id="pet_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        <option value="">Select Pet</option>
                        @foreach($pets as $pet)
                            <option value="{{ $pet->id }}" data-customer="{{ $pet->customer_id }}" {{ old('pet_id') == $pet->id ? 'selected' : '' }}>
                                {{ $pet->name }} ({{ $pet->species }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Booking Date *</label>
                        <input type="date" name="booking_date" value="{{ old('booking_date', date('Y-m-d')) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Booking Time *</label>
                        <input type="time" name="booking_time" value="{{ old('booking_time', '09:00') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Service Type *</label>
                    <select name="service_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
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
                    <label class="block text-sm font-medium text-gray-700">Reason</label>
                    <textarea name="reason" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">{{ old('reason') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" rows="2"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">{{ old('notes') }}</textarea>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                    <p class="text-sm text-blue-700">
                        <i class="fas fa-info-circle mr-2"></i>
                        Queue number will be automatically assigned based on the booking date.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('bookings.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Create Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
