@extends('layouts.vetech')

@section('title', 'Add Pet - VETech')
@section('header', 'Add New Pet')

@section('content')
<div class="mb-6">
    <a href="{{ route('customers.index') }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>Back to Customers
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-4 p-3 bg-blue-50 rounded">
            <p class="text-sm font-semibold">Owner: {{ $customer->name }}</p>
            <p class="text-xs text-gray-600">IC: {{ $customer->ic_number }}</p>
        </div>

        <form action="{{ route('customers.pets.store', $customer) }}" method="POST">
            @csrf
            
            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Pet Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Species *</label>
                        <input type="text" name="species" value="{{ old('species') }}" placeholder="e.g., Dog, Cat" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Breed</label>
                        <input type="text" name="breed" value="{{ old('breed') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gender *</label>
                        <select name="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Age (years)</label>
                        <input type="number" name="age" value="{{ old('age') }}" min="0" placeholder="e.g. 2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Color</label>
                        <input type="text" name="color" value="{{ old('color') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                        <input type="number" name="weight" value="{{ old('weight') }}" step="0.01" min="0"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                </div>



                <div>
                    <label class="block text-sm font-medium text-gray-700">Special Notes</label>
                    <textarea name="special_notes" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">{{ old('special_notes') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('customers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Save Pet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
