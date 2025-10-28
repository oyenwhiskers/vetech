@extends('layouts.vetech')

@section('title', 'Pet Details - VETech')
@section('header', 'Pet Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('customers.index', ['view' => $customer->id]) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>Back to Customer
    </a>
</div>


<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Pet Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-2xl p-8 flex flex-col gap-4">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-2xl font-bold text-[#334da1] flex items-center gap-2">
                    <i class="fas fa-paw"></i> Pet Information
                </h3>
                <div class="flex gap-2">
                    <a href="{{ route('customers.pets.edit', [$customer, $pet]) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-2 rounded-lg transition-colors text-sm font-medium" title="Edit Pet">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('customers.pets.destroy', [$customer, $pet]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this pet? All treatment records will also be deleted.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-colors text-sm font-medium" title="Delete Pet">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="flex flex-col gap-2 text-gray-800">
                <div class="flex items-center gap-2">
                    <i class="fas fa-dog text-[#334da1]"></i>
                    <span class="font-semibold text-lg">{{ $pet->name }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-user text-gray-500"></i>
                    <span>{{ $customer->name }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-dna text-gray-500"></i>
                    <span>{{ $pet->species }} / {{ $pet->breed ?: 'N/A' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-venus-mars text-gray-500"></i>
                    <span>{{ ucfirst($pet->gender) }}</span>
                </div>
                @if($pet->age)
                <div class="flex items-center gap-2">
                    <i class="fas fa-hourglass-half text-gray-500"></i>
                    <span>{{ $pet->age }} years old</span>
                </div>
                @endif
                @if($pet->weight)
                <div class="flex items-center gap-2">
                    <i class="fas fa-weight text-gray-500"></i>
                    <span>{{ $pet->weight }} kg</span>
                </div>
                @endif
                @if($pet->color)
                <div class="flex items-center gap-2">
                    <i class="fas fa-palette text-gray-500"></i>
                    <span>{{ $pet->color }}</span>
                </div>
                @endif
                @if($pet->microchip_number)
                <div class="flex items-center gap-2">
                    <i class="fas fa-microchip text-gray-500"></i>
                    <span>{{ $pet->microchip_number }}</span>
                </div>
                @endif
                @if($pet->tag)
                <div class="flex items-center gap-2">
                    <i class="fas fa-qrcode text-green-600"></i>
                    <a href="{{ route('tags.show', $pet->tag) }}" class="text-green-600 hover:text-green-800 font-semibold">
                        {{ $pet->tag->tag_code }}
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Treatment History -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-[#334da1] flex items-center gap-2">
                    <i class="fas fa-notes-medical"></i> Treatment History ({{ $pet->treatments->count() }})
                </h3>
                <button onclick="document.getElementById('addTreatmentModal').classList.remove('hidden')" 
                    class="bg-[#334da1] hover:bg-[#2a3d85] text-white px-4 py-2 rounded-lg text-base font-semibold flex items-center gap-2">
                    <i class="fas fa-plus"></i> Add Treatment
                </button>
            </div>

            @if($pet->treatments->count() > 0)
                <div class="space-y-4">
                    @foreach($pet->treatments as $treatment)
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <span class="font-bold text-lg text-[#334da1] flex items-center gap-2">
                                        <i class="fas fa-calendar-day"></i> {{ $treatment->treatment_date->format('d M Y') }}
                                    </span>
                                    <span class="text-sm text-gray-600 flex items-center gap-2">
                                        <i class="fas fa-user-md"></i> By {{ $treatment->user->name }}
                                        @if($treatment->collaborator)
                                            <span class="ml-2"><i class="fas fa-clinic-medical"></i> {{ $treatment->collaborator->clinic_name }}</span>
                                        @endif
                                    </span>
                                </div>
                                <span class="px-3 py-1 text-xs rounded-full {{ $treatment->treatment_location == 'government' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }} font-semibold">
                                    {{ ucfirst($treatment->treatment_location) }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                                @if($treatment->disease)
                                    <div class="text-sm"><strong>Disease:</strong> {{ $treatment->disease }}</div>
                                @endif
                                <div class="text-sm"><strong>Diagnosis:</strong> {{ $treatment->diagnosis }}</div>
                                <div class="text-sm"><strong>Treatment:</strong> {{ $treatment->treatment_given }}</div>
                                @if($treatment->medication)
                                    <div class="text-sm"><strong>Medication:</strong> {{ $treatment->medication }}</div>
                                @endif
                                @if($treatment->treated_by)
                                    <div class="text-sm"><strong>Treated By:</strong> {{ $treatment->treated_by }}</div>
                                @endif
                                @if($treatment->cost)
                                    <div class="text-sm"><strong>Cost:</strong> RM {{ number_format($treatment->cost, 2) }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                    <i class="fas fa-notes-medical text-4xl text-gray-400 mb-3"></i>
                    <p class="text-gray-500 font-medium">No treatment records yet</p>
                </div>
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
                    <label class="block text-sm font-medium text-gray-700">Treated By</label>
                    <input type="text" name="treated_by" value="{{ Auth::user()->name }}"
                        placeholder="e.g., Dr. Smith, Dr. Johnson"
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
