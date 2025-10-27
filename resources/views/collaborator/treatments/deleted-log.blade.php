@extends('layouts.vetech')

@section('title', 'Deleted Treatments Log')
@section('header', 'Deleted Treatment Records')

@section('content')
<div class="mb-6">
    <a href="{{ route('collaborator.treatments.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
        <i class="fas fa-arrow-left mr-2"></i>Back to Treatments
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6 border-b bg-red-50">
        <h3 class="text-lg font-semibold text-gray-900">Deleted Treatment Records Audit Log</h3>
        <p class="text-sm text-gray-600 mt-1">
            These records have been deleted but are kept for audit purposes. Total: {{ $deletedTreatments->total() }} records
        </p>
    </div>

    @if($deletedTreatments->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Treatment Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disease/Diagnosis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deleted Info</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($deletedTreatments as $treatment)
                        <tr class="bg-red-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $treatment->treatment_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $treatment->pet->name }}</div>
                                <div class="text-xs text-gray-500">{{ ucfirst($treatment->pet->species) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $treatment->pet->customer->name }}</div>
                                <div class="text-xs text-gray-500">{{ $treatment->pet->customer->phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    @if($treatment->disease)
                                        <span class="font-medium">{{ $treatment->disease }}</span><br>
                                    @endif
                                    <span class="text-gray-600">{{ Str::limit($treatment->diagnosis, 50) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div>{{ $treatment->deleted_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">
                                    By: {{ $treatment->deleter->name ?? 'Unknown' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('collaborator.treatments.show', $treatment) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t">
            {{ $deletedTreatments->links() }}
        </div>
    @else
        <div class="p-12 text-center text-gray-500">
            <i class="fas fa-check-circle text-5xl mb-4 text-green-500"></i>
            <p class="text-lg">No deleted records found.</p>
            <p class="text-sm mt-2">All your treatment records are active.</p>
        </div>
    @endif
</div>

<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <p class="text-sm text-blue-800">
        <i class="fas fa-info-circle mr-2"></i>
        <strong>About Deleted Log:</strong> When you delete a treatment record, it's moved here for audit purposes. The record remains viewable but is marked as deleted, showing who deleted it and when. This ensures full accountability and traceability of all medical records.
    </p>
</div>
@endsection
