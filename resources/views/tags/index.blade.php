@extends('layouts.vetech')

@section('title', 'Tags - VETech')
@section('header', 'Manage Tags & QR Codes')

@section('content')
<div x-data="{ viewMode: 'card' }">
<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-lg p-8 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-3xl font-bold mb-2 flex items-center">
                    <i class="fas fa-qrcode mr-3"></i>Pet Tag Management
                </h3>
                <p class="text-blue-100 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>Generate and manage QR codes for pet identification
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <!-- View Toggle -->
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-1 flex gap-1">
                    <button @click="viewMode = 'card'" 
                            :class="viewMode === 'card' ? 'bg-white text-blue-600' : 'text-white hover:bg-white/10'"
                            class="px-4 py-2 rounded-md transition-all font-medium flex items-center">
                        <i class="fas fa-th-large mr-2"></i>
                        <span class="hidden sm:inline">Card</span>
                    </button>
                    <button @click="viewMode = 'list'" 
                            :class="viewMode === 'list' ? 'bg-white text-blue-600' : 'text-white hover:bg-white/10'"
                            class="px-4 py-2 rounded-md transition-all font-medium flex items-center">
                        <i class="fas fa-list mr-2"></i>
                        <span class="hidden sm:inline">List</span>
                    </button>
                </div>
                <a href="{{ route('tags.create') }}" 
                   class="bg-white text-blue-600 hover:bg-blue-50 font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center">
                    <i class="fas fa-plus-circle mr-2"></i>Generate New Tag
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Tags Grid (Card View) -->
<div x-show="viewMode === 'card'" 
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 transform scale-95"
     x-transition:enter-end="opacity-100 transform scale-100"
     class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($tags as $tag)
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
            <!-- Status Badge -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    @if($tag->pet)
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-lg text-gray-800 truncate flex items-center">
                                <i class="fas fa-paw text-purple-500 mr-2"></i>{{ $tag->pet->name }}
                            </h4>
                            <p class="text-sm text-gray-600 truncate">
                                <i class="fas fa-user text-blue-500 mr-1"></i>{{ $tag->pet->customer->name }}
                            </p>
                        </div>
                    @else
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-500 flex items-center">
                                <i class="fas fa-tag mr-2"></i>Unassigned Tag
                            </h4>
                            <p class="text-sm text-amber-600 flex items-center">
                                <i class="fas fa-mobile-alt mr-1"></i>Assign via mobile app
                            </p>
                        </div>
                    @endif
                    <span class="ml-3 px-3 py-1 text-xs font-bold rounded-full whitespace-nowrap
                        @if($tag->status == 'active') bg-green-100 text-green-700
                        @elseif($tag->status == 'inactive') bg-gray-100 text-gray-700
                        @else bg-red-100 text-red-700
                        @endif">
                        {{ ucfirst($tag->status) }}
                    </span>
                </div>
            </div>

            <!-- QR Code Display -->
            <div class="flex justify-center p-6 bg-gradient-to-br from-blue-50 to-indigo-50">
                @if($tag->qr_code_path)
                        <div class="bg-white p-3 rounded-lg shadow-md border-4 border-white">
                        <img src="{{ $tag->qr_code_path }}" 
                             alt="QR Code" 
                                 class="w-44 h-44 object-contain">
                    </div>
                @else
                    <div class="w-48 h-48 bg-gray-200 flex items-center justify-center rounded-xl">
                        <p class="text-gray-500"><i class="fas fa-qrcode text-3xl"></i></p>
                    </div>
                @endif
            </div>

            <!-- Tag Code & Date -->
            <div class="px-6 py-4 bg-white border-t border-gray-100">
                <div class="text-center mb-4">
                    <div class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-4 py-2 rounded-full mb-2">
                        <i class="fas fa-hashtag mr-2"></i>
                        <span class="font-mono text-lg font-bold">{{ $tag->tag_code }}</span>
                    </div>
                    <p class="text-xs text-gray-500 flex items-center justify-center">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        Issued: {{ $tag->issued_date->format('d M Y') }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <a href="{{ route('tags.show', $tag) }}" 
                       class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                        <i class="fas fa-eye mr-2"></i>View
                    </a>
                    <a href="{{ route('tags.download', $tag) }}" 
                       class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                        <i class="fas fa-download mr-2"></i>Download
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border-2 border-dashed border-gray-300 p-12 text-center">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-qrcode text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Tags Generated Yet</h3>
                    <p class="text-gray-500 mb-6">Start by generating your first QR code tag for pet identification</p>
                    <a href="{{ route('tags.create') }}" 
                       class="inline-flex items-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all">
                        <i class="fas fa-plus-circle mr-2"></i>Generate Your First Tag
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Tags List (List View) -->
<div x-show="viewMode === 'list'" 
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 transform scale-95"
     x-transition:enter-end="opacity-100 transform scale-100"
     class="bg-white rounded-xl shadow-lg overflow-hidden">
    @if($tags->count() > 0)
        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-blue-600 to-indigo-600">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                            <i class="fas fa-qrcode mr-2"></i>QR Code
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                            <i class="fas fa-hashtag mr-2"></i>Tag Code
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                            <i class="fas fa-paw mr-2"></i>Pet Name
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                            <i class="fas fa-user mr-2"></i>Owner
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                            <i class="fas fa-info-circle mr-2"></i>Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                            <i class="fas fa-calendar-alt mr-2"></i>Issued Date
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">
                            <i class="fas fa-cog mr-2"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($tags as $tag)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($tag->qr_code_path)
                                    <div class="w-16 h-16 bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden flex items-center justify-center">
                                        <img src="{{ $tag->qr_code_path }}" 
                                             alt="QR Code" 
                                             class="w-full h-full object-contain p-0.5">
                                    </div>
                                @else
                                    <div class="w-16 h-16 bg-gray-100 flex items-center justify-center rounded-lg">
                                        <i class="fas fa-qrcode text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-3 py-1 rounded-full">
                                    <span class="font-mono font-bold">{{ $tag->tag_code }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($tag->pet)
                                    <div class="text-sm font-medium text-gray-900 flex items-center">
                                        <i class="fas fa-paw text-purple-500 mr-2"></i>
                                        {{ $tag->pet->name }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ ucfirst($tag->pet->species) }}</div>
                                @else
                                    <span class="text-sm text-gray-500 italic flex items-center">
                                        <i class="fas fa-tag text-amber-500 mr-2"></i>
                                        Unassigned
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($tag->pet)
                                    <div class="text-sm text-gray-900">{{ $tag->pet->customer->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $tag->pet->customer->phone }}</div>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-bold rounded-full
                                    @if($tag->status == 'active') bg-green-100 text-green-700
                                    @elseif($tag->status == 'inactive') bg-gray-100 text-gray-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    {{ ucfirst($tag->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $tag->issued_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('tags.show', $tag) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center">
                                        <i class="fas fa-eye mr-1"></i>
                                        <span class="hidden lg:inline">View</span>
                                    </a>
                                    <a href="{{ route('tags.download', $tag) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center">
                                        <i class="fas fa-download mr-1"></i>
                                        <span class="hidden lg:inline">Download</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View for List Mode -->
        <div class="md:hidden divide-y divide-gray-200">
            @foreach($tags as $tag)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-4">
                        <!-- QR Code Thumbnail -->
                        <div class="flex-shrink-0">
                            @if($tag->qr_code_path)
                                <div class="w-20 h-20 bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden flex items-center justify-center">
                                    <img src="{{ $tag->qr_code_path }}" 
                                         alt="QR Code" 
                                         class="w-full h-full object-contain p-0.5">
                                </div>
                            @else
                                <div class="w-20 h-20 bg-gray-100 flex items-center justify-center rounded-lg">
                                    <i class="fas fa-qrcode text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Tag Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-3 py-1 rounded-full">
                                    <span class="font-mono font-bold text-sm">{{ $tag->tag_code }}</span>
                                </div>
                                <span class="px-2 py-1 text-xs font-bold rounded-full
                                    @if($tag->status == 'active') bg-green-100 text-green-700
                                    @elseif($tag->status == 'inactive') bg-gray-100 text-gray-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    {{ ucfirst($tag->status) }}
                                </span>
                            </div>

                            @if($tag->pet)
                                <p class="text-sm font-medium text-gray-900 flex items-center mb-1">
                                    <i class="fas fa-paw text-purple-500 mr-2"></i>{{ $tag->pet->name }}
                                </p>
                                <p class="text-xs text-gray-600 mb-1">
                                    <i class="fas fa-user text-blue-500 mr-1"></i>{{ $tag->pet->customer->name }}
                                </p>
                            @else
                                <p class="text-sm text-gray-500 italic flex items-center mb-1">
                                    <i class="fas fa-tag text-amber-500 mr-2"></i>Unassigned Tag
                                </p>
                            @endif

                            <p class="text-xs text-gray-500">
                                <i class="fas fa-calendar-alt mr-1"></i>{{ $tag->issued_date->format('d M Y') }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="flex gap-2 mt-3">
                                <a href="{{ route('tags.show', $tag) }}" 
                                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-2 rounded-lg transition-all shadow-sm flex items-center justify-center">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <a href="{{ route('tags.download', $tag) }}" 
                                   class="flex-1 bg-green-600 hover:bg-green-700 text-white text-sm px-3 py-2 rounded-lg transition-all shadow-sm flex items-center justify-center">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="p-12 text-center">
            <i class="fas fa-qrcode text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Tags Generated Yet</h3>
            <p class="text-gray-500 mb-6">Start by generating your first QR code tag for pet identification</p>
            <a href="{{ route('tags.create') }}" 
               class="inline-flex items-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all">
                <i class="fas fa-plus-circle mr-2"></i>Generate Your First Tag
            </a>
        </div>
    @endif
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $tags->links() }}
</div>
</div>
@endsection
