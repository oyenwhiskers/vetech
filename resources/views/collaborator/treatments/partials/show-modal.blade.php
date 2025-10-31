@php
    // Helper to render a storage or http image safely
    $petImage = (function($raw) {
        $placeholder = 'https://www.animalfocusvet.com/wp-content/uploads/sites/272/2023/01/Placeholder-23.png';
        if (!$raw) return $placeholder;
        $isHttp = preg_match('#^https?://#i', $raw) === 1;
        $isStorageUrl = strpos($raw, '/storage/') === 0;
        if ($isHttp || $isStorageUrl) return $raw;
        $normalized = ltrim(preg_replace('#^/?storage/#', '', $raw), '/');
        return asset('storage/' . $normalized);
    })($treatment->pet->pet_image ?? null);
@endphp

<div class="bg-white">
    @if($treatment->trashed())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
            <p class="font-bold"><i class="fas fa-exclamation-triangle mr-2"></i>This treatment record has been deleted</p>
            <p class="text-sm mt-1">Deleted by {{ $treatment->deleter->name ?? 'Unknown' }} on {{ $treatment->deleted_at->format('M d, Y \a\t H:i') }}</p>
        </div>
    @endif

    <div class="p-5">
        <div class="space-y-4 text-sm">
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
            @if($treatment->notes)
                <div>
                    <h5 class="font-semibold text-gray-900 mb-1">Additional Notes</h5>
                    <p class="text-gray-700 whitespace-pre-line">{{ $treatment->notes }}</p>
                </div>
            @endif
        </div>

        <div class="mt-6 pt-6 border-t grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <dt class="font-medium text-gray-600">Treated By</dt>
                <dd class="text-gray-900 mt-1">{{ $treatment->treated_by ?? $treatment->user->name }}</dd>
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
                <dt class="font-medium text-gray-600">Record Created By</dt>
                <dd class="text-gray-900 mt-1">
                    {{ $treatment->user->name }}
                    <br><span class="text-xs text-gray-600">{{ $treatment->created_at->format('M d, Y H:i') }}</span>
                </dd>
            </div>
        </div>
    </div>
</div>
