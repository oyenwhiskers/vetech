@extends('layouts.vetech')

@section('title', 'Treatment Details')
@section('header', 'Treatment Record Details')

@section('content')
<div class="max-w-4xl mx-auto">
    @if($treatment->trashed())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <p class="font-bold"><i class="fas fa-exclamation-triangle mr-2"></i>This treatment record has been deleted</p>
            <p class="text-sm mt-1">Deleted by {{ $treatment->deleter->name ?? 'Unknown' }} on {{ $treatment->deleted_at->format('F d, Y \a\t H:i') }}</p>
        </div>
    @endif

    <!-- Treatment Details -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold">Treatment Record</h3>
                <span class="px-3 py-1 bg-white/20 rounded-full text-sm">
                    {{ $treatment->treatment_date->format('F d, Y') }}
                </span>
            </div>
        </div>

        <div class="p-6">
            <!-- Pet & Owner Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 pb-6 border-b">
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">Pet Information</h4>
                    <dl class="space-y-2 text-sm">
                        <div class="flex">
                            <dt class="font-medium text-gray-600 w-24">Name:</dt>
                            <dd class="text-gray-900">{{ $treatment->pet->name }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="font-medium text-gray-600 w-24">Species:</dt>
                            <dd class="text-gray-900">{{ ucfirst($treatment->pet->species) }}</dd>
                        </div>
                        @if($treatment->pet->breed)
                            <div class="flex">
                                <dt class="font-medium text-gray-600 w-24">Breed:</dt>
                                <dd class="text-gray-900">{{ $treatment->pet->breed }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">Owner Information</h4>
                    <dl class="space-y-2 text-sm">
                        <div class="flex">
                            <dt class="font-medium text-gray-600 w-24">Name:</dt>
                            <dd class="text-gray-900">{{ $treatment->pet->customer->name }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="font-medium text-gray-600 w-24">Phone:</dt>
                            <dd class="text-gray-900">{{ $treatment->pet->customer->phone }}</dd>
                        </div>
                        @if($treatment->pet->customer->email)
                            <div class="flex">
                                <dt class="font-medium text-gray-600 w-24">Email:</dt>
                                <dd class="text-gray-900">{{ $treatment->pet->customer->email }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Treatment Details -->
            <div class="space-y-4">
                @if($treatment->disease)
                    <div>
                        <h5 class="font-semibold text-gray-900 mb-1">Disease/Condition</h5>
                        <p class="text-gray-700">{{ $treatment->disease }}</p>
                    </div>
                @endif

                <div>
                    <h5 class="font-semibold text-gray-900 mb-1">Diagnosis</h5>
                    <p class="text-gray-700 whitespace-pre-line">{{ $treatment->diagnosis }}</p>
                </div>

                <div>
                    <h5 class="font-semibold text-gray-900 mb-1">Treatment Given</h5>
                    <p class="text-gray-700 whitespace-pre-line">{{ $treatment->treatment_given }}</p>
                </div>

                @if($treatment->medication)
                    <div>
                        <h5 class="font-semibold text-gray-900 mb-1">Medication Prescribed</h5>
                        <p class="text-gray-700 whitespace-pre-line">{{ $treatment->medication }}</p>
                    </div>
                @endif

                @if($treatment->cost)
                    <div>
                        <h5 class="font-semibold text-gray-900 mb-1">Treatment Cost</h5>
                        <p class="text-gray-700 text-lg">RM {{ number_format($treatment->cost, 2) }}</p>
                    </div>
                @endif

                @if($treatment->notes)
                    <div>
                        <h5 class="font-semibold text-gray-900 mb-1">Additional Notes</h5>
                        <p class="text-gray-700 whitespace-pre-line">{{ $treatment->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Meta Information -->
            <div class="mt-6 pt-6 border-t bg-gray-50 -mx-6 px-6 py-4">
                <dl class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <dt class="font-medium text-gray-600">Treated By</dt>
                        <dd class="text-gray-900 mt-1">{{ $treatment->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-600">Location</dt>
                        <dd class="text-gray-900 mt-1">
                            {{ ucfirst($treatment->treatment_location) }}
                            @if($treatment->collaborator)
                                <br><span class="text-xs text-gray-600">{{ $treatment->collaborator->clinic_name }}</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-600">Record Created</dt>
                        <dd class="text-gray-900 mt-1">{{ $treatment->created_at->format('M d, Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex justify-between items-center">
        <a href="{{ route('collaborator.treatments.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to Treatments
        </a>

        @if($canDelete)
            <form method="POST" action="{{ route('collaborator.treatments.destroy', $treatment) }}" 
                  onsubmit="return confirm('Are you sure you want to delete this treatment record? It will be moved to the deleted log for audit purposes.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                    <i class="fas fa-trash mr-2"></i>Delete Record
                </button>
            </form>
        @elseif($treatment->trashed())
            <span class="text-sm text-red-600 font-medium">
                <i class="fas fa-lock mr-1"></i>Record Deleted
            </span>
        @else
            <span class="text-sm text-gray-500">
                <i class="fas fa-lock mr-1"></i>View Only (Created by another collaborator)
            </span>
        @endif
    </div>
</div>
@endsection
