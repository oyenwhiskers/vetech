@extends('layouts.vetech')

@section('title', 'Tag Details - VETech')
@section('header', 'Tag Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('tags.index') }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>Back to Tags
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Tag Information -->
    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-semibold">Tag Information</h3>
                <span class="px-2 py-1 text-xs rounded-full 
                    @if($tag->status == 'active') bg-green-100 text-green-800
                    @elseif($tag->status == 'inactive') bg-gray-100 text-gray-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($tag->status) }}
                </span>
            </div>

            <div class="space-y-3 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Tag Code</p>
                    <p class="font-mono text-lg font-semibold">{{ $tag->tag_code }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pet</p>
                    <p class="font-semibold">
                        <a href="{{ route('customers.pets.show', [$tag->pet->customer, $tag->pet]) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $tag->pet->name }}
                        </a>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Owner</p>
                    <p>
                        <a href="{{ route('customers.show', $tag->pet->customer) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $tag->pet->customer->name }}
                        </a>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Issued Date</p>
                    <p>{{ $tag->issued_date->format('d M Y') }}</p>
                </div>
                @if($tag->notes)
                <div>
                    <p class="text-sm text-gray-500">Notes</p>
                    <p>{{ $tag->notes }}</p>
                </div>
                @endif
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('tags.download', $tag) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex-1 text-center">
                    <i class="fas fa-download mr-2"></i>Download QR Code
                </a>
                <a href="{{ route('tags.edit', $tag) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- QR Code Display -->
    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">QR Code</h3>
            <div class="flex flex-col items-center">
                @if($tag->qr_code_path)
                    @php
                        $isUrl = Str::startsWith($tag->qr_code_path, ['http://', 'https://']);
                    @endphp
                    <img src="{{ $isUrl ? $tag->qr_code_path : asset('storage/' . $tag->qr_code_path) }}" alt="QR Code" class="w-64 h-64 mb-4">
                    <p class="text-sm text-gray-600 text-center mb-4">
                        Scan this QR code to view pet information and treatment history
                    </p>
                    <a href="{{ route('tags.scan', $tag->tag_code) }}" target="_blank" 
                        class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-external-link-alt mr-2"></i>Preview Scan Page
                    </a>
                @else
                    <div class="w-64 h-64 bg-gray-200 flex items-center justify-center mb-4">
                        <p class="text-gray-500">QR Code not available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
