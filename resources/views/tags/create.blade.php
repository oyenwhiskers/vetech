@extends('layouts.vetech')

@section('title', 'Generate Tag - VETech')
@section('header', 'Generate New Tag')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('tags.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Select Pet *</label>
                    <select name="pet_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        <option value="">Select Pet</option>
                        @foreach($pets as $pet)
                            <option value="{{ $pet->id }}" {{ old('pet_id') == $pet->id ? 'selected' : '' }}>
                                {{ $pet->name }} ({{ $pet->species }}) - Owner: {{ $pet->customer->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Only pets without tags are shown</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Issue Date *</label>
                    <input type="date" name="issued_date" value="{{ old('issued_date', date('Y-m-d')) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">{{ old('notes') }}</textarea>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                A unique QR code will be automatically generated for this pet. 
                                The QR code can be printed and attached to the pet's collar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('tags.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-qrcode mr-2"></i>Generate Tag
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
