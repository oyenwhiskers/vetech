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
            <div class="mb-4 flex justify-center items-center">
                <?php
                $placeholder = 'https://www.animalfocusvet.com/wp-content/uploads/sites/272/2023/01/Placeholder-23.png';
                $raw = $pet->pet_image ?? null;
                if ($raw) {
                    $isHttp = preg_match('#^https?://#i', $raw) === 1;
                    $isStorageUrl = strpos($raw, '/storage/') === 0;
                    if ($isHttp || $isStorageUrl) {
                        $imgSrc = $raw;
                    } else {
                        $normalized = ltrim(preg_replace('#^/?storage/#', '', $raw), '/');
                        $imgSrc = asset('storage/' . $normalized);
                    }
                } else {
                    $imgSrc = $placeholder;
                }
                ?>
                <img src="{{ $imgSrc }}" alt="Pet Image" class="w-40 h-40 rounded-xl object-cover border" />
            </div>
            <div class="flex flex-col gap-3 text-gray-800">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-3">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fas fa-paw text-[#334da1]"></i>
                        </span>
                        <span class="text-sm text-gray-500">Name</span>
                    </div>
                    <span class="font-semibold text-lg">{{ $pet->name }}</span>
                </div>

                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-3">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fas fa-user text-gray-500"></i>
                        </span>
                        <span class="text-sm text-gray-500">Owner</span>
                    </div>
                    <span class="font-medium">{{ $customer->name }}</span>
                </div>

                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-3">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fas fa-dna text-gray-500"></i>
                        </span>
                        <span class="text-sm text-gray-500">Breed</span>
                    </div>
                    <span class="font-medium">{{ $pet->species }} / {{ $pet->breed ?: 'N/A' }}</span>
                </div>

                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-3">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fas fa-venus-mars text-gray-500"></i>
                        </span>
                        <span class="text-sm text-gray-500">Gender</span>
                    </div>
                    <span class="font-medium">{{ ucfirst($pet->gender) }}</span>
                </div>

                @if($pet->age)
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-3">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fas fa-hourglass-half text-gray-500"></i>
                        </span>
                        <span class="text-sm text-gray-500">Age</span>
                    </div>
                    <span class="px-2.5 py-1 text-xs rounded-full bg-blue-50 text-blue-700 font-semibold">{{ $pet->age }} years</span>
                </div>
                @endif

                @if($pet->weight)
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-3">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fas fa-weight text-gray-500"></i>
                        </span>
                        <span class="text-sm text-gray-500">Weight</span>
                    </div>
                    <span class="px-2.5 py-1 text-xs rounded-full bg-emerald-50 text-emerald-700 font-semibold">{{ $pet->weight }} kg</span>
                </div>
                @endif

                @if($pet->color)
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-3">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fas fa-palette text-gray-500"></i>
                        </span>
                        <span class="text-sm text-gray-500">Color</span>
                    </div>
                    <span class="font-medium">{{ $pet->color }}</span>
                </div>
                @endif

                @if($pet->microchip_number)
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-3">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fas fa-microchip text-gray-500"></i>
                        </span>
                        <span class="text-sm text-gray-500">Microchip</span>
                    </div>
                    <span class="px-2.5 py-1 text-xs rounded-md bg-gray-100 text-gray-700 font-mono tracking-wide">{{ $pet->microchip_number }}</span>
                </div>
                @endif

                @if($pet->tag)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fas fa-qrcode text-green-600"></i>
                        </span>
                        <span class="text-sm text-gray-500">Tag</span>
                    </div>
                    <a href="{{ route('tags.show', $pet->tag) }}" class="px-3 py-1 text-xs rounded-full bg-green-50 text-green-700 hover:bg-green-100 font-semibold transition-colors">
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
                    @foreach($pet->treatments->sortByDesc('treatment_date') as $treatment)
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
                                @if($treatment->cost && $treatment->treatment_location == 'government')
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
<div id="addTreatmentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
    <div class="w-full h-full flex items-center justify-center p-4 overflow-y-auto">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 relative">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <span class="bg-blue-600 text-white rounded-full flex items-center justify-center w-12 h-12 shadow-lg">
                        <i class="fas fa-notes-medical text-2xl"></i>
                    </span>
                    <h3 class="text-xl md:text-2xl font-bold text-[#334da1]">Add Treatment Record</h3>
                </div>
                <button onclick="document.getElementById('addTreatmentModal').classList.add('hidden')" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="{{ route('customers.pets.treatments.store', [$customer, $pet]) }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-calendar-day mr-1 text-blue-600"></i> Treatment Date *</label>
                        <input type="date" name="treatment_date" value="{{ date('Y-m-d') }}" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-user-md mr-1 text-blue-600"></i> Treated By</label>
                        <input type="text" name="treated_by" value="{{ Auth::user()->name }}"
                            placeholder="e.g., Dr. Smith, Dr. Johnson"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-viruses mr-1 text-blue-600"></i> Disease (if any)</label>
                    <input type="text" name="disease"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-file-medical mr-1 text-blue-600"></i> Diagnosis *</label>
                    <textarea name="diagnosis" rows="3" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-syringe mr-1 text-blue-600"></i> Treatment Given *</label>
                    <textarea name="treatment_given" rows="3" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-pills mr-1 text-blue-600"></i> Medication</label>
                    <textarea name="medication" rows="2"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-temperature-high mr-1 text-blue-600"></i> Temperature (°C)</label>
                        <input type="number" name="temperature" step="0.01" min="0"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-weight mr-1 text-blue-600"></i> Weight (kg)</label>
                        <input type="number" name="weight" step="0.01" min="0"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-dollar-sign mr-1 text-blue-600"></i> Cost (RM)</label>
                        <input type="number" name="cost" step="0.01" min="0"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-sticky-note mr-1 text-blue-600"></i> Notes</label>
                        <textarea name="notes" rows="2"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base"></textarea>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-2">
                <button type="button" onclick="document.getElementById('addTreatmentModal').classList.add('hidden')"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="bg-[#334da1] hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-save"></i> Save Treatment
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
