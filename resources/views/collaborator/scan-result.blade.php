@extends('layouts.vetech')

@section('title', 'Scan Result - ' . $tag->tag_code)
@section('header', 'Pet Medical Record')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Pet & Owner Info -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4 gap-3">
            <div class="flex-1">
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $tag->pet->name }}</h3>
                <div class="text-sm sm:text-base text-gray-600 space-y-1 sm:space-y-0 mt-2">
                    <p>
                        <span class="font-medium">Tag:</span> {{ $tag->tag_code }}
                    </p>
                    <p>
                        <span class="font-medium">Species:</span> {{ ucfirst($tag->pet->species) }}
                        @if($tag->pet->breed)
                            <span class="sm:ml-4 block sm:inline"><span class="font-medium">Breed:</span> {{ $tag->pet->breed }}</span>
                        @endif
                    </p>
                </div>
            </div>
            <a href="{{ route('collaborator.treatments.create', $tag->pet) }}" 
               class="w-full sm:w-auto text-center px-4 py-2.5 sm:py-2 bg-blue-600 text-white rounded-md hover:bg-blue-800 transition font-medium">
                <i class="fas fa-plus mr-2"></i>Add Treatment
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 pt-4 border-t">
            <div class="col-span-1 flex justify-center items-center">
                <?php
                $placeholder = 'https://www.animalfocusvet.com/wp-content/uploads/sites/272/2023/01/Placeholder-23.png';
                $raw = $tag->pet->pet_image ?? null;
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
                <img src="{{ $imgSrc }}" alt="Pet Image" class="w-24 h-24 rounded-xl object-cover border" />
            </div>
            <div class="col-span-2">
                <h4 class="font-semibold text-gray-900 mb-2 text-sm sm:text-base">Pet Information</h4>
                <dl class="space-y-1 text-xs sm:text-sm">
                    <div><dt class="inline font-medium">Gender:</dt> <dd class="inline">{{ ucfirst($tag->pet->gender) }}</dd></div>
                    @if($tag->pet->age)
                        <div><dt class="inline font-medium">Age:</dt> <dd class="inline">{{ $tag->pet->age }} years</dd></div>
                    @endif
                    @if($tag->pet->weight)
                        <div><dt class="inline font-medium">Weight:</dt> <dd class="inline">{{ $tag->pet->weight }} kg</dd></div>
                    @endif
                    @if($tag->pet->color)
                        <div><dt class="inline font-medium">Color:</dt> <dd class="inline">{{ $tag->pet->color }}</dd></div>
                    @endif
                </dl>
            </div>
            <div class="col-span-1 flex justify-center items-center">
                <?php
                $placeholder = 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png?20150327203541';
                $raw = $tag->pet->customer->profile_image ?? null;
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
                <img src="{{ $imgSrc }}" alt="Customer Profile Image" class="w-24 h-24 rounded-xl object-cover border" />
            </div>
            <div class="col-span-2">
                <h4 class="font-semibold text-gray-900 mb-2 text-sm sm:text-base">Owner Information</h4>
                <dl class="space-y-1 text-xs sm:text-sm">
                    <div><dt class="inline font-medium">Name:</dt> <dd class="inline">{{ $tag->pet->customer->name }}</dd></div>
                    <div><dt class="inline font-medium">Phone:</dt> <dd class="inline">{{ $tag->pet->customer->phone }}</dd></div>
                    @if($tag->pet->customer->email)
                        <div><dt class="inline font-medium">Email:</dt> <dd class="inline break-all">{{ $tag->pet->customer->email }}</dd></div>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <!-- Treatment History -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">Treatment History</h3>

        @if($tag->pet->treatments->count() > 0)
            <div class="space-y-3 sm:space-y-4">
                @foreach($tag->pet->treatments as $treatment)
                    <div class="border rounded-lg p-3 sm:p-4 {{ $treatment->trashed() ? 'bg-red-50 border-red-200' : 'bg-gray-50' }}">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-2 gap-2">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <span class="font-semibold text-gray-900 text-sm sm:text-base">
                                        {{ $treatment->treatment_date->format('M d, Y') }}
                                    </span>
                                    @if($treatment->trashed())
                                        <span class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                            <i class="fas fa-trash-alt mr-1"></i>DELETED
                                        </span>
                                    @endif
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                        {{ ucfirst($treatment->treatment_location) }}
                                    </span>
                                </div>
                                @if($treatment->disease)
                                    <p class="text-xs sm:text-sm text-gray-600"><span class="font-medium">Disease:</span> {{ $treatment->disease }}</p>
                                @endif
                                <p class="text-xs sm:text-sm text-gray-600"><span class="font-medium">Diagnosis:</span> {{ $treatment->diagnosis }}</p>
                            </div>
                            <div class="text-left sm:text-right text-xs sm:text-sm text-gray-600">
                                <p class="font-medium">{{ $treatment->treated_by ?? $treatment->user->name }}</p>
                                @if($treatment->collaborator)
                                    <p class="text-xs">{{ $treatment->collaborator->clinic_name }}</p>
                                @endif
                                @if($treatment->treated_by && $treatment->treated_by !== $treatment->user->name)
                                    <p class="text-xs text-gray-500">Record by: {{ $treatment->user->name }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-xs sm:text-sm text-gray-700 mt-2 space-y-1">
                            <p><span class="font-medium">Treatment:</span> {{ $treatment->treatment_given }}</p>
                            @if($treatment->treated_by)
                                <p><span class="font-medium">Treated By:</span> {{ $treatment->treated_by }}</p>
                            @endif
                            @if($treatment->medication)
                                <p><span class="font-medium">Medication:</span> {{ $treatment->medication }}</p>
                            @endif
                            @if($treatment->notes)
                                <p><span class="font-medium">Notes:</span> {{ $treatment->notes }}</p>
                            @endif
                        </div>

                        @if($treatment->trashed())
                            <div class="mt-2 pt-2 border-t border-red-200 text-xs text-red-600">
                                Deleted by {{ $treatment->deleter->name ?? 'Unknown' }} on {{ $treatment->deleted_at->format('M d, Y H:i') }}
                            </div>
                        @endif

                        <div class="mt-3 flex flex-wrap gap-2">
                            <a href="{{ route('collaborator.treatments.show', $treatment) }}" 
                               class="text-xs sm:text-sm text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-eye mr-1"></i>View Details
                            </a>
                            @if(!$treatment->trashed() && $treatment->canBeDeletedBy(Auth::user()))
                                <form method="POST" action="{{ route('collaborator.treatments.destroy', $treatment) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this treatment record? It will be moved to the deleted log.');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs sm:text-sm text-red-600 hover:text-red-800 font-medium">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
                            @elseif(!$treatment->trashed())
                                <span class="text-xs sm:text-sm text-gray-400">
                                    <i class="fas fa-lock mr-1"></i>View Only
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-clipboard-list text-3xl sm:text-4xl mb-3"></i>
                <p class="text-sm sm:text-base">No treatment records found.</p>
                <a href="{{ route('collaborator.treatments.create', $tag->pet) }}" 
                   class="inline-block mt-3 text-sm sm:text-base text-blue-600 hover:text-blue-800 font-medium">
                    Add the first treatment record
                </a>
            </div>
        @endif
    </div>

    <div class="mt-4 sm:mt-6 mb-4">
        <a href="{{ route('collaborator.scanner') }}" class="inline-block text-sm sm:text-base text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to Scanner
        </a>
    </div>
</div>
@endsection
