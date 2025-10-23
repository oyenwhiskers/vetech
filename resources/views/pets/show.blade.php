@extends('layouts.vetech')

@section('title', 'Pet Details - VETech')
@section('header', 'Pet Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>Back to Customer
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Pet Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-semibold">Pet Information</h3>
                <a href="{{ route('customers.pets.edit', [$customer, $pet]) }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="font-semibold text-lg">{{ $pet->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Owner</p>
                    <p><a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:text-blue-800">{{ $customer->name }}</a></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Species / Breed</p>
                    <p>{{ $pet->species }} / {{ $pet->breed ?: 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Gender</p>
                    <p>{{ ucfirst($pet->gender) }}</p>
                </div>
                @if($pet->date_of_birth)
                <div>
                    <p class="text-sm text-gray-500">Age</p>
                    <p>{{ $pet->age }} years old</p>
                </div>
                @endif
                @if($pet->weight)
                <div>
                    <p class="text-sm text-gray-500">Weight</p>
                    <p>{{ $pet->weight }} kg</p>
                </div>
                @endif
                @if($pet->color)
                <div>
                    <p class="text-sm text-gray-500">Color</p>
                    <p>{{ $pet->color }}</p>
                </div>
                @endif
                @if($pet->microchip_number)
                <div>
                    <p class="text-sm text-gray-500">Microchip</p>
                    <p>{{ $pet->microchip_number }}</p>
                </div>
                @endif
                @if($pet->tag)
                <div>
                    <p class="text-sm text-gray-500">Tag Status</p>
                    <a href="{{ route('tags.show', $pet->tag) }}" class="text-green-600 hover:text-green-800">
                        <i class="fas fa-qrcode mr-1"></i>{{ $pet->tag->tag_code }}
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Treatment History -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Treatment History ({{ $pet->treatments->count() }})</h3>
                <button onclick="document.getElementById('addTreatmentModal').classList.remove('hidden')" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-plus mr-2"></i>Add Treatment
                </button>
            </div>

            @if($pet->treatments->count() > 0)
                <div class="space-y-4">
                    @foreach($pet->treatments as $treatment)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-semibold">{{ $treatment->treatment_date->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-600">By {{ $treatment->user->name }}
                                        @if($treatment->collaborator)
                                            at {{ $treatment->collaborator->clinic_name }}
                                        @endif
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full {{ $treatment->treatment_location == 'government' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ ucfirst($treatment->treatment_location) }}
                                </span>
                            </div>
                            @if($treatment->disease)
                                <p class="text-sm"><strong>Disease:</strong> {{ $treatment->disease }}</p>
                            @endif
                            <p class="text-sm"><strong>Diagnosis:</strong> {{ $treatment->diagnosis }}</p>
                            <p class="text-sm"><strong>Treatment:</strong> {{ $treatment->treatment_given }}</p>
                            @if($treatment->medication)
                                <p class="text-sm"><strong>Medication:</strong> {{ $treatment->medication }}</p>
                            @endif
                            @if($treatment->cost)
                                <p class="text-sm"><strong>Cost:</strong> RM {{ number_format($treatment->cost, 2) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No treatment records yet</p>
            @endif
        </div>
    </div>
</div>

<!-- Add Treatment Modal -->
<div id="addTreatmentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Add Treatment Record</h3>
            <button onclick="document.getElementById('addTreatmentModal').classList.add('hidden')" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('customers.pets.treatments.store', [$customer, $pet]) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Treatment Date *</label>
                    <input type="date" name="treatment_date" value="{{ date('Y-m-d') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Disease (if any)</label>
                    <input type="text" name="disease"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Diagnosis *</label>
                    <textarea name="diagnosis" rows="3" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Treatment Given *</label>
                    <textarea name="treatment_given" rows="3" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Medication</label>
                    <textarea name="medication" rows="2"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cost (RM)</label>
                    <input type="number" name="cost" step="0.01" min="0"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" rows="2"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('addTreatmentModal').classList.add('hidden')"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Save Treatment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
