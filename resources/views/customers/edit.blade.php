@extends('layouts.vetech')

@section('title', 'Edit Customer - VETech')
@section('header', 'Edit Customer')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-100 rounded-2xl shadow-2xl p-8">
        <div class="flex items-center gap-4 mb-8">
            <span class="bg-blue-600 text-white rounded-full flex items-center justify-center w-16 h-16 shadow-lg">
                <i class="fas fa-user-edit text-3xl"></i>
            </span>
            <h2 class="text-2xl font-bold text-[#2563eb]">Edit Customer</h2>
        </div>
        <form action="{{ route('customers.update', $customer) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-user mr-1 text-blue-600"></i> Name *</label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-id-card mr-1 text-blue-600"></i> IC Number *</label>
                    <input type="text" name="ic_number" value="{{ old('ic_number', $customer->ic_number) }}" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-envelope mr-1 text-blue-600"></i> Email</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-phone mr-1 text-blue-600"></i> Phone *</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-map-marker-alt mr-1 text-blue-600"></i> Address</label>
                <textarea name="address" rows="3"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">{{ old('address', $customer->address) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('customers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="bg-[#334da1] hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-save"></i> Update Customer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
