@extends('layouts.vetech')

@section('title', 'My Treatments')
@section('header', 'My Treatment Records')

@section('content')
<div class="mb-4 sm:mb-6 flex flex-col sm:flex-row gap-3 sm:gap-0 sm:justify-between sm:items-center px-4 sm:px-0">
    <div>
        <a href="{{ route('collaborator.scanner') }}" 
           class="inline-block w-full sm:w-auto text-center px-4 py-2.5 sm:py-2 bg-[#550000] text-white rounded-md hover:bg-[#3a0000] transition font-medium">
            <i class="fas fa-qrcode mr-2"></i>Scan Tag
        </a>
    </div>
    <a href="{{ route('collaborator.treatments.deleted-log') }}" 
       class="text-center sm:text-left text-gray-600 hover:text-gray-800 font-medium py-2 sm:py-0">
        <i class="fas fa-trash mr-2"></i>View Deleted Log
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden mx-4 sm:mx-0">
    <div class="p-4 sm:p-6 border-b">
        <h3 class="text-base sm:text-lg font-semibold text-gray-900">All Treatment Records</h3>
        <p class="text-xs sm:text-sm text-gray-600 mt-1">Total: {{ $treatments->total() }} records</p>
    </div>

    @if($treatments->count() > 0)
        <!-- Mobile Card View -->
        <div class="block sm:hidden divide-y divide-gray-200">
            @foreach($treatments as $treatment)
                <div class="p-4 {{ $treatment->trashed() ? 'bg-red-50' : '' }}">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">{{ $treatment->pet->name }}</div>
                            <div class="text-xs text-gray-500">{{ ucfirst($treatment->pet->species) }} • {{ $treatment->treatment_date->format('M d, Y') }}</div>
                        </div>
                        @if($treatment->trashed())
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Deleted
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        @endif
                    </div>
                    
                    <div class="text-sm text-gray-600 mb-2">
                        <div><span class="font-medium">Owner:</span> {{ $treatment->pet->customer->name }}</div>
                        <div><span class="font-medium">Phone:</span> {{ $treatment->pet->customer->phone }}</div>
                        @if($treatment->disease)
                            <div><span class="font-medium">Disease:</span> {{ $treatment->disease }}</div>
                        @endif
                        <div><span class="font-medium">Diagnosis:</span> {{ Str::limit($treatment->diagnosis, 50) }}</div>
                    </div>
                    
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('collaborator.treatments.show', $treatment) }}" 
                           class="text-sm text-[#550000] hover:text-[#3a0000] font-medium">
                            <i class="fas fa-eye mr-1"></i>View
                        </a>
                        @if(!$treatment->trashed())
                            <form method="POST" action="{{ route('collaborator.treatments.destroy', $treatment) }}" 
                                  onsubmit="return confirm('Move this treatment to deleted log?');"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-900 font-medium">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Desktop Table View -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disease/Diagnosis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($treatments as $treatment)
                        <tr class="{{ $treatment->trashed() ? 'bg-red-50' : '' }}">
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($treatment->trashed())
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Deleted
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('collaborator.treatments.show', $treatment) }}" 
                                   class="text-[#550000] hover:text-[#3a0000] mr-3">
                                    View
                                </a>
                                @if(!$treatment->trashed())
                                    <form method="POST" action="{{ route('collaborator.treatments.destroy', $treatment) }}" 
                                          onsubmit="return confirm('Move this treatment to deleted log?');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-4 sm:px-6 py-4 border-t">
            {{ $treatments->links() }}
        </div>
    @else
        <div class="p-8 sm:p-12 text-center text-gray-500">
            <i class="fas fa-clipboard-list text-4xl sm:text-5xl mb-3 sm:mb-4"></i>
            <p class="text-base sm:text-lg">No treatment records found.</p>
            <a href="{{ route('collaborator.scanner') }}" 
               class="inline-block mt-3 sm:mt-4 px-6 py-2.5 sm:py-2 bg-[#550000] text-white rounded-md hover:bg-[#3a0000] transition font-medium">
                Scan a Pet Tag to Add Treatment
            </a>
        </div>
    @endif
</div>
@endsection
