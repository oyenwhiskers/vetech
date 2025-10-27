@extends('layouts.vetech')

@section('title', 'Generate Tag - VETech')
@section('header', 'Generate New Tag')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 rounded-2xl shadow-2xl p-8">
        <!-- Header Section -->
        <div class="flex items-center gap-4 mb-8">
            <div class="bg-blue-600 text-white rounded-full flex items-center justify-center w-16 h-16 shadow-lg">
                <i class="fas fa-qrcode text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-[#334da1]">Generate New QR Tag</h2>
                <p class="text-gray-600">Create a new QR code tag for pet identification</p>
            </div>
        </div>

        <form action="{{ route('tags.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Info Alert -->
            <div class="bg-blue-100 border-l-4 border-blue-500 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-blue-800">Tag Generation Process</h3>
                        <p class="text-sm text-blue-700 mt-1">
                            You can create tags without assigning them to pets. Pet assignment can be done later through the mobile app by scanning the QR code.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pet Selection (Optional) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-paw mr-1 text-blue-600"></i> Assign to Pet (Optional)
                    </label>
                    <select name="pet_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                        <option value="">-- Assign Later via Mobile App --</option>
                        @foreach($pets as $pet)
                            <option value="{{ $pet->id }}" {{ old('pet_id') == $pet->id ? 'selected' : '' }}>
                                {{ $pet->name }} ({{ $pet->species }}) - Owner: {{ $pet->customer->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-mobile-alt mr-1"></i> Leave empty to assign the pet later using the mobile app
                    </p>
                </div>

                <!-- Issue Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-1 text-blue-600"></i> Issue Date *
                    </label>
                    <input type="date" name="issued_date" value="{{ old('issued_date', date('Y-m-d')) }}" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>

                <!-- Quantity (for batch generation) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-hashtag mr-1 text-blue-600"></i> Quantity
                    </label>
                    <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" max="50" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                    <p class="mt-1 text-sm text-gray-500">Generate multiple tags at once (max 50)</p>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-sticky-note mr-1 text-blue-600"></i> Notes
                </label>
                <textarea name="notes" rows="3"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"
                    placeholder="Add any additional information about this tag...">{{ old('notes') }}</textarea>
            </div>

            <!-- Feature Highlight -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <div class="bg-green-500 text-white rounded-full p-2 flex-shrink-0">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-green-800 mb-1">Automatic QR Code Generation</h4>
                        <p class="text-sm text-green-700">
                            A unique QR code will be automatically generated for each tag. The QR code can be printed and attached to the pet's collar for easy identification and treatment tracking.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-4 border-t">
                <a href="{{ route('tags.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="bg-[#334da1] hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold flex items-center gap-2 transition-colors shadow-lg">
                    <i class="fas fa-qrcode"></i> Generate Tag
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
