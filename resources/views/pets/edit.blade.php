@extends('layouts.vetech')

@section('title', 'Edit Pet - VETech')
@section('header', 'Edit Pet')

@section('content')

<div class="mb-6">
    <a href="{{ route('customers.pets.show', [$customer, $pet]) }}" class="text-[#334da1] hover:text-blue-800 font-semibold flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Pet Details
    </a>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-100 rounded-2xl shadow-2xl p-8">
        <div class="flex items-center gap-3 mb-6">
            <span class="bg-blue-600 text-white rounded-full flex items-center justify-center w-12 h-12 shadow-lg">
                <i class="fas fa-dog text-2xl"></i>
            </span>
            <h2 class="text-2xl font-bold text-[#334da1]">Edit Pet</h2>
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

        <form action="{{ route('customers.pets.update', [$customer, $pet]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-paw mr-1 text-blue-600"></i> Pet Name *</label>
                    <input type="text" name="name" value="{{ old('name', $pet->name) }}" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-dna mr-1 text-blue-600"></i> Breed</label>
                    <input type="text" name="breed" value="{{ old('breed', $pet->breed) }}"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-dog mr-1 text-blue-600"></i> Species *</label>
                    <input type="text" name="species" value="{{ old('species', $pet->species) }}" placeholder="e.g., Dog, Cat" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-venus-mars mr-1 text-blue-600"></i> Gender *</label>
                    <select name="gender" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', $pet->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $pet->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-hourglass-half mr-1 text-blue-600"></i> Age (years)</label>
                    <input type="number" name="age" min="0" value="{{ old('age', $pet->age ?? '') }}"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base" placeholder="e.g. 2">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-palette mr-1 text-blue-600"></i> Color</label>
                    <input type="text" name="color" value="{{ old('color', $pet->color) }}"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-weight mr-1 text-blue-600"></i> Weight (kg)</label>
                    <input type="number" name="weight" value="{{ old('weight', $pet->weight) }}" step="0.01" min="0"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-sticky-note mr-1 text-blue-600"></i> Special Notes</label>
                <textarea name="special_notes" rows="3"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">{{ old('special_notes', $pet->special_notes) }}</textarea>
            </div>

            <div class="flex items-center justify-between mt-8">
                <button @click="window.dispatchEvent(new CustomEvent('open-delete-pet-modal', { detail: { id: {{ $pet->id }}, name: '{{ addslashes($pet->name) }}' } }))"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-trash"></i> Delete Pet
                </button>
                <div class="flex gap-3">
                    <a href="{{ route('customers.pets.show', [$customer, $pet]) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="bg-[#334da1] hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                        <i class="fas fa-save"></i> Update Pet
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Pet Confirmation Modal -->
<div x-data="{ open: false, petId: null, petName: '' }"
     x-on:open-delete-pet-modal.window="petId = $event.detail.id; petName = $event.detail.name; open = true">
    <template x-if="open">
        <div @click.self="open = false" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8" x-transition>
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-red-600 text-white rounded-full flex items-center justify-center w-12 h-12">
                        <i class="fas fa-trash-alt text-2xl"></i>
                    </span>
                    <h3 class="text-xl font-bold text-red-700">Delete Pet</h3>
                </div>
                <p class="mb-6 text-gray-700">Are you sure you want to delete <span class="font-semibold" x-text="petName"></span>? This action cannot be undone and will remove all related records.</p>
                <form :action="'/customers/{{ $customer->id }}/pets/' + petId" method="POST" @submit.prevent="if($el.checkValidity()){ $el.submit(); open = false; }">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-3 mt-4">
                        <button type="button" @click="open = false" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>
@endsection
