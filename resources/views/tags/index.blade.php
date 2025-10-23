@extends('layouts.vetech')

@section('title', 'Tags - VETech')
@section('header', 'Manage Tags & QR Codes')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-lg font-semibold">Pet Tag Management</h3>
        <p class="text-sm text-gray-600">Generate and manage QR codes for pet identification</p>
    </div>
    <a href="{{ route('tags.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i>Generate New Tag
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($tags as $tag)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-semibold text-lg">{{ $tag->pet->name }}</h4>
                    <p class="text-sm text-gray-600">Owner: {{ $tag->pet->customer->name }}</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full 
                    @if($tag->status == 'active') bg-green-100 text-green-800
                    @elseif($tag->status == 'inactive') bg-gray-100 text-gray-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($tag->status) }}
                </span>
            </div>

            <div class="flex justify-center mb-4">
                @if($tag->qr_code_path)
                    <img src="{{ asset('storage/' . $tag->qr_code_path) }}" alt="QR Code" class="w-48 h-48">
                @else
                    <div class="w-48 h-48 bg-gray-200 flex items-center justify-center">
                        <p class="text-gray-500">No QR Code</p>
                    </div>
                @endif
            </div>

            <div class="text-center mb-4">
                <p class="font-mono text-sm font-semibold">{{ $tag->tag_code }}</p>
                <p class="text-xs text-gray-500">Issued: {{ $tag->issued_date->format('d M Y') }}</p>
            </div>

            <div class="flex justify-center space-x-2">
                <a href="{{ route('tags.show', $tag) }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-eye"></i> View
                </a>
                <a href="{{ route('tags.download', $tag) }}" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-download"></i> Download
                </a>
                <a href="{{ route('tags.edit', $tag) }}" class="text-yellow-600 hover:text-yellow-800">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12 text-gray-500">
            No tags generated yet
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $tags->links() }}
</div>
@endsection
