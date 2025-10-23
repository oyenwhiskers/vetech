@extends('layouts.vetech')

@section('title', 'Edit Pet - VETech')
@section('header', 'Edit Pet')

@section('content')
<div class="mb-6">
    <a href="{{ route('customers.pets.show', [$customer, $pet]) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>Back to Pet Details
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-4 p-3 bg-blue-50 rounded">
            <p class="text-sm font-semibold">Owner: {{ $customer->name }}</p>
            <p class="text-xs text-gray-600">IC: {{ $customer->ic_number }}</p>
        </div>

        <form action="{{ route('customers.pets.update', [$customer, $pet]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pet Name *</label>
                    <input type="text" name="name" value="{{ old('name', $pet->name) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Species *</label>
                        <input type="text" name="species" value="{{ old('species', $pet->species) }}" placeholder="e.g., Dog, Cat" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Breed</label>
                        <input type="text" name="breed" value="{{ old('breed', $pet->breed) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gender *</label>
                        <select name="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $pet->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $pet->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $pet->date_of_birth?->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Color</label>
                        <input type="text" name="color" value="{{ old('color', $pet->color) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                        <input type="number" name="weight" value="{{ old('weight', $pet->weight) }}" step="0.01" min="0"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Microchip Number</label>
                    <input type="text" name="microchip_number" value="{{ old('microchip_number', $pet->microchip_number) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Special Notes</label>
                    <textarea name="special_notes" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">{{ old('special_notes', $pet->special_notes) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-between">
                <form action="{{ route('customers.pets.destroy', [$customer, $pet]) }}" method="POST" 
                    onsubmit="return confirm('Are you sure you want to delete this pet? All related records will be affected.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-trash mr-2"></i>Delete Pet
                    </button>
                </form>

                <div class="flex space-x-3">
                    <a href="{{ route('customers.pets.show', [$customer, $pet]) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Update Pet
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
