@extends('layouts.vetech')

@section('title', 'Add Treatment')
@section('header', 'Add Treatment Record')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Pet Info Card -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">{{ $pet->name }}</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 text-sm">
            <div class="space-y-1">
                <p><span class="font-medium">Species:</span> {{ ucfirst($pet->species) }}</p>
                @if($pet->breed)
                    <p><span class="font-medium">Breed:</span> {{ $pet->breed }}</p>
                @endif
            </div>
            <div class="space-y-1">
                <p><span class="font-medium">Owner:</span> {{ $pet->customer->name }}</p>
                <p><span class="font-medium">Phone:</span> {{ $pet->customer->phone }}</p>
            </div>
        </div>
    </div>

    <!-- Treatment Form -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <form method="POST" action="{{ route('collaborator.treatments.store', $pet) }}">
            @csrf

            <div class="space-y-4 sm:space-y-5">
                <!-- Treatment Date -->
                <div>
                    <label for="treatment_date" class="block text-sm font-medium text-gray-700 mb-1">
                        Treatment Date <span class="text-red-600">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="treatment_date" 
                        name="treatment_date" 
                        value="{{ old('treatment_date', date('Y-m-d')) }}"
                        max="{{ date('Y-m-d') }}"
                        class="w-full text-base border-gray-300 focus:border-[#550000] focus:ring-[#550000] rounded-md shadow-sm"
                        required
                    />
                    @error('treatment_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Disease -->
                <div>
                    <label for="disease" class="block text-sm font-medium text-gray-700 mb-1">
                        Disease/Condition
                    </label>
                    <input 
                        type="text" 
                        id="disease" 
                        name="disease" 
                        value="{{ old('disease') }}"
                        placeholder="e.g., Parvovirus, Skin infection"
                        class="w-full text-base border-gray-300 focus:border-[#550000] focus:ring-[#550000] rounded-md shadow-sm"
                    />
                    @error('disease')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Diagnosis -->
                <div>
                    <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-1">
                        Diagnosis <span class="text-red-600">*</span>
                    </label>
                    <textarea 
                        id="diagnosis" 
                        name="diagnosis" 
                        rows="3"
                        placeholder="Describe the diagnosis and symptoms observed..."
                        class="w-full text-base border-gray-300 focus:border-[#550000] focus:ring-[#550000] rounded-md shadow-sm"
                        required
                    >{{ old('diagnosis') }}</textarea>
                    @error('diagnosis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Treatment Given -->
                <div>
                    <label for="treatment_given" class="block text-sm font-medium text-gray-700 mb-1">
                        Treatment Given <span class="text-red-600">*</span>
                    </label>
                    <textarea 
                        id="treatment_given" 
                        name="treatment_given" 
                        rows="3"
                        placeholder="Describe the treatment procedures performed..."
                        class="w-full text-base border-gray-300 focus:border-[#550000] focus:ring-[#550000] rounded-md shadow-sm"
                        required
                    >{{ old('treatment_given') }}</textarea>
                    @error('treatment_given')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Medication -->
                <div>
                    <label for="medication" class="block text-sm font-medium text-gray-700 mb-1">
                        Medication Prescribed
                    </label>
                    <textarea 
                        id="medication" 
                        name="medication" 
                        rows="2"
                        placeholder="List medications with dosage and frequency..."
                        class="w-full text-base border-gray-300 focus:border-[#550000] focus:ring-[#550000] rounded-md shadow-sm"
                    >{{ old('medication') }}</textarea>
                    @error('medication')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cost -->
                <div>
                    <label for="cost" class="block text-sm font-medium text-gray-700 mb-1">
                        Treatment Cost (RM)
                    </label>
                    <input 
                        type="number" 
                        id="cost" 
                        name="cost" 
                        value="{{ old('cost') }}"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        class="w-full text-base border-gray-300 focus:border-[#550000] focus:ring-[#550000] rounded-md shadow-sm"
                    />
                    @error('cost')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                        Additional Notes
                    </label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="2"
                        placeholder="Any additional observations or follow-up instructions..."
                        class="w-full text-base border-gray-300 focus:border-[#550000] focus:ring-[#550000] rounded-md shadow-sm"
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-between gap-3">
                <a href="{{ url()->previous() }}" 
                   class="w-full sm:w-auto text-center px-4 py-2.5 sm:py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition font-medium">
                    Cancel
                </a>
                <button 
                    type="submit"
                    class="w-full sm:w-auto px-6 py-2.5 sm:py-2 bg-[#550000] text-white rounded-md hover:bg-[#3a0000] focus:outline-none focus:ring-2 focus:ring-[#550000] focus:ring-offset-2 transition font-medium"
                >
                    <i class="fas fa-save mr-2"></i>Save Treatment Record
                </button>
            </div>
        </form>
    </div>

    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4">
        <p class="text-xs sm:text-sm text-blue-800">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Note:</strong> All treatment records are permanently saved and cannot be edited. You can only delete your own records, which will move them to the deleted log for audit purposes.
        </p>
    </div>
</div>
@endsection
