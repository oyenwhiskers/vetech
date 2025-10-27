@extends('layouts.vetech')

@section('title', 'Tag Details - VETech')
@section('header', 'Tag Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('tags.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
        <i class="fas fa-arrow-left mr-2"></i>Back to Tags
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- QR Code Display - Left Column -->
    <div class="lg:col-span-1">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl shadow-lg p-8 sticky top-6">
            <div class="flex justify-center mb-4">
                <div class="bg-white p-6 rounded-2xl shadow-md">
                    @if($tag->qr_code_path)
                        @php
                            $isUrl = Str::startsWith($tag->qr_code_path, ['http://', 'https://']);
                        @endphp
                        <img src="{{ $isUrl ? $tag->qr_code_path : asset('storage/' . $tag->qr_code_path) }}" 
                             alt="QR Code" 
                             class="w-64 h-64 object-contain">
                    @else
                        <div class="w-64 h-64 bg-gray-200 flex items-center justify-center rounded-lg">
                            <p class="text-gray-500">No QR Code</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center bg-white px-6 py-3 rounded-full shadow-md mb-3">
                    <i class="fas fa-qrcode text-blue-600 mr-3 text-xl"></i>
                    <span class="font-mono text-2xl font-bold text-gray-800">{{ $tag->tag_code }}</span>
                </div>
                <p class="text-sm text-gray-600">
                    <i class="fas fa-mobile-alt mr-1"></i>Scan with your mobile device
                </p>
            </div>

            @if($tag->qr_code_path)
                <a href="{{ route('tags.scan', $tag->tag_code) }}" target="_blank" 
                   class="block w-full text-center bg-white border-2 border-blue-300 text-blue-700 font-semibold py-3 px-4 rounded-lg hover:bg-blue-50 transition-colors mb-3">
                    <i class="fas fa-external-link-alt mr-2"></i>Preview Scan Page
                </a>
            @endif
        </div>
    </div>

    <!-- Tag Information - Right Column -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header with Status -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-tag mr-3"></i>Tag Information
                    </h3>
                    <span class="px-4 py-2 text-sm font-semibold rounded-full 
                        @if($tag->status == 'active') bg-green-500 text-white
                        @elseif($tag->status == 'inactive') bg-gray-500 text-white
                        @else bg-red-500 text-white
                        @endif">
                        <i class="fas fa-circle mr-1 text-xs"></i>{{ ucfirst($tag->status) }}
                    </span>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Pet Information -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-paw text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-700">Pet Details</h4>
                        </div>
                        @if($tag->pet)
                            <a href="{{ route('customers.pets.show', [$tag->pet->customer, $tag->pet]) }}" 
                               class="block text-xl font-bold text-purple-700 hover:text-purple-900 mb-2">
                                {{ $tag->pet->name }}
                            </a>
                            <p class="text-sm text-gray-600">{{ $tag->pet->species ?? 'Pet' }}</p>
                        @else
                            <div class="flex items-start">
                                <i class="fas fa-mobile-alt text-amber-500 mt-1 mr-2"></i>
                                <div>
                                    <p class="font-semibold text-gray-700">Not assigned yet</p>
                                    <p class="text-sm text-amber-600">Assign via mobile app</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Owner Information -->
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-6 border border-blue-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-700">Owner Details</h4>
                        </div>
                        @if($tag->pet)
                            <a href="{{ route('customers.show', $tag->pet->customer) }}" 
                               class="block text-xl font-bold text-blue-700 hover:text-blue-900 mb-2">
                                {{ $tag->pet->customer->name }}
                            </a>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-phone mr-1"></i>{{ $tag->pet->customer->contact_number ?? '-' }}
                            </p>
                        @else
                            <p class="text-gray-400 text-lg">-</p>
                        @endif
                    </div>

                    <!-- Issue Date -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-alt text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-700">Issued Date</h4>
                        </div>
                        <p class="text-xl font-bold text-green-700">{{ $tag->issued_date->format('d M Y') }}</p>
                        <p class="text-sm text-gray-600">{{ $tag->issued_date->diffForHumans() }}</p>
                    </div>

                    <!-- Notes -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-sticky-note text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-700">Notes</h4>
                        </div>
                        @if($tag->notes)
                            <p class="text-gray-700">{{ $tag->notes }}</p>
                        @else
                            <p class="text-gray-400 italic">No notes</p>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('tags.download', $tag) }}" 
                       class="flex-1 min-w-[200px] bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold px-6 py-3 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                        <i class="fas fa-download mr-2"></i>Download QR Code
                    </a>
                    <a href="{{ route('tags.edit', $tag) }}" 
                       class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold px-6 py-3 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" 
                            class="bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white font-semibold px-6 py-3 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                        <i class="fas fa-trash mr-2"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Delete Tag</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete this tag ({{ $tag->tag_code }})?
                    @if($tag->pet)
                        This tag is currently assigned to <strong>{{ $tag->pet->name }}</strong>.
                    @endif
                    This action cannot be undone.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form action="{{ route('tags.destroy', $tag) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Delete
                    </button>
                </form>
                <button onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="ml-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
