@extends('layouts.vetech')

@section('title', 'Add Pet - VETech')
@section('header', 'Add New Pet')

@section('content')
<div class="mb-6">
    <a href="{{ route('customers.index') }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>Back to Customers
    </a>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-100 rounded-2xl shadow-2xl p-8">
        <div class="flex items-center gap-3 mb-6">
            <span class="bg-blue-600 text-white rounded-full flex items-center justify-center w-12 h-12 shadow-lg">
                <i class="fas fa-paw text-2xl"></i>
            </span>
            <h2 class="text-2xl font-bold text-[#334da1]">Add New Pet</h2>
        </div>
        <div class="mb-6 p-4 bg-blue-50 rounded-lg flex flex-col md:flex-row md:items-center gap-2">
            <div class="flex items-center gap-2">
                <i class="fas fa-user text-blue-600"></i>
                <span class="font-semibold">Owner:</span>
                <span class="font-bold text-gray-900">{{ $customer->name }}</span>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-600 md:ml-6">
                <i class="fas fa-id-card"></i>
                <span>IC: {{ $customer->ic_number }}</span>
            </div>
        </div>

        <form action="{{ route('customers.pets.store', $customer) }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="space-y-6">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-paw mr-1 text-blue-600"></i> Pet Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-dog mr-1 text-blue-600"></i> Species *</label>
                        <input type="text" name="species" value="{{ old('species') }}" placeholder="e.g., Dog, Cat" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-dna mr-1 text-blue-600"></i> Breed</label>
                        <input type="text" name="breed" value="{{ old('breed') }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-venus-mars mr-1 text-blue-600"></i> Gender *</label>
                        <select name="gender" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-hourglass-half mr-1 text-blue-600"></i> Age (years)</label>
                        <input type="number" name="age" value="{{ old('age') }}" min="0" placeholder="e.g. 2"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-palette mr-1 text-blue-600"></i> Color</label>
                        <input type="text" name="color" value="{{ old('color') }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-weight mr-1 text-blue-600"></i> Weight (kg)</label>
                        <input type="number" name="weight" value="{{ old('weight') }}" step="0.01" min="0"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                    </div>
                </div>



                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-sticky-note mr-1 text-blue-600"></i> Special Notes</label>
                    <textarea name="special_notes" rows="3"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">{{ old('special_notes') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-2">
                <a href="{{ route('customers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="bg-[#334da1] hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-save"></i> Save Pet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
