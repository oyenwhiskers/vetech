@extends('layouts.vetech')

@section('title', 'Add Treatment')
@section('header', 'Add Treatment Record')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Pet Info Card -->
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-100 rounded-2xl shadow-2xl p-6 sm:p-8 mb-4 sm:mb-6">
        <div class="flex items-center gap-3 mb-3">
            <span class="bg-blue-600 text-white rounded-full flex items-center justify-center w-12 h-12 shadow-lg">
                <i class="fas fa-paw text-2xl"></i>
            </span>
            <h3 class="text-xl sm:text-2xl font-bold text-[#334da1]">{{ $pet->name }}</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 text-sm">
            <div class="space-y-1">
                <p class="flex items-center gap-2"><i class="fas fa-dog text-blue-600"></i><span class="font-medium">Species:</span> {{ ucfirst($pet->species) }}</p>
                @if($pet->breed)
                    <p class="flex items-center gap-2"><i class="fas fa-dna text-blue-600"></i><span class="font-medium">Breed:</span> {{ $pet->breed }}</p>
                @endif
            </div>
            <div class="space-y-1">
                <p class="flex items-center gap-2"><i class="fas fa-user text-blue-600"></i><span class="font-medium">Owner:</span> {{ $pet->customer->name }}</p>
                <p class="flex items-center gap-2"><i class="fas fa-phone text-blue-600"></i><span class="font-medium">Phone:</span> {{ $pet->customer->phone }}</p>
            </div>
        </div>
    </div>

    <!-- Treatment Form -->
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-100 rounded-2xl shadow-2xl p-6 md:p-8">
        <div class="flex items-center gap-3 mb-6">
            <span class="bg-blue-600 text-white rounded-full flex items-center justify-center w-12 h-12 shadow-lg">
                <i class="fas fa-notes-medical text-2xl"></i>
            </span>
            <h2 class="text-2xl font-bold text-[#334da1]">Add Treatment Record</h2>
        </div>
        <form method="POST" action="{{ route('collaborator.treatments.store', $pet) }}" class="space-y-6">
            @csrf

            <div class="space-y-6">
                <!-- Treatment Date -->
                <div>
                    <label for="treatment_date" class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-calendar-day mr-1 text-blue-600"></i> Treatment Date <span class="text-red-600">*</span></label>
                    <input 
                        type="date" 
                        id="treatment_date" 
                        name="treatment_date" 
                        value="{{ old('treatment_date', date('Y-m-d')) }}"
                        max="{{ date('Y-m-d') }}"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"
                        required
                    />
                    @error('treatment_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Treated By -->
                <div>
                    <label for="treated_by" class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-user-md mr-1 text-blue-600"></i> Treated By</label>
                    <input 
                        type="text" 
                        id="treated_by" 
                        name="treated_by" 
                        value="{{ old('treated_by', Auth::user()->name) }}"
                        placeholder="e.g., Dr. Smith, Dr. Johnson"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"
                    />
                    @error('treated_by')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Disease -->
                <div>
                    <label for="disease" class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-viruses mr-1 text-blue-600"></i> Disease/Condition</label>
                    <input 
                        type="text" 
                        id="disease" 
                        name="disease" 
                        value="{{ old('disease') }}"
                        placeholder="e.g., Parvovirus, Skin infection"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"
                    />
                    @error('disease')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Diagnosis -->
                <div>
                    <label for="diagnosis" class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-file-medical mr-1 text-blue-600"></i> Diagnosis <span class="text-red-600">*</span></label>
                    <textarea 
                        id="diagnosis" 
                        name="diagnosis" 
                        rows="3"
                        placeholder="Describe the diagnosis and symptoms observed..."
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"
                        required
                    >{{ old('diagnosis') }}</textarea>
                    @error('diagnosis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Treatment Given -->
                <div>
                    <label for="treatment_given" class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-syringe mr-1 text-blue-600"></i> Treatment Given <span class="text-red-600">*</span></label>
                    <textarea 
                        id="treatment_given" 
                        name="treatment_given" 
                        rows="3"
                        placeholder="Describe the treatment procedures performed..."
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"
                        required
                    >{{ old('treatment_given') }}</textarea>
                    @error('treatment_given')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Medication -->
                <div>
                    <label for="medication" class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-pills mr-1 text-blue-600"></i> Medication Prescribed</label>
                    <textarea 
                        id="medication" 
                        name="medication" 
                        rows="2"
                        placeholder="List medications with dosage and frequency..."
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"
                    >{{ old('medication') }}</textarea>
                    @error('medication')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Temperature and Weight -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="temperature" class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-temperature-high mr-1 text-blue-600"></i> Temperature (°C)</label>
                        <input type="number" id="temperature" name="temperature" value="{{ old('temperature') }}" step="0.01" min="0"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"
                        />
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-weight mr-1 text-blue-600"></i> Weight (kg)</label>
                        <input type="number" id="weight" name="weight" value="{{ old('weight') }}" step="0.01" min="0"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"
                        />
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-sticky-note mr-1 text-blue-600"></i> Additional Notes</label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="2"
                        placeholder="Any additional observations or follow-up instructions..."
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-2">
                <a href="{{ url()->previous() }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="bg-[#334da1] hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-save"></i> Save Treatment Record
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
