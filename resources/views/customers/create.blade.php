@extends('layouts.vetech')

@section('title', 'Add Customer - VETech')
@section('header', 'Add New Customer')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">IC Number *</label>
                    <input type="text" name="ic_number" value="{{ old('ic_number') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">{{ old('address') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('customers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Save Customer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
