@extends('layouts.vetech')

@section('title', 'Edit Tag - VETech')
@section('header', 'Edit Tag')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-100 rounded-2xl shadow-2xl p-8">
        <div class="flex items-center gap-4 mb-8">
            <span class="bg-blue-600 text-white rounded-full flex items-center justify-center w-16 h-16 shadow-lg">
                <i class="fas fa-tag text-3xl"></i>
            </span>
            <h2 class="text-2xl font-bold text-[#2563eb]">Edit Tag</h2>
        </div>
        <form action="{{ route('tags.update', $tag) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-hashtag mr-1 text-blue-600"></i> Tag Code</label>
                    <input type="text" value="{{ $tag->tag_code }}" disabled
                        class="block w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm p-3 border text-base">
                    <p class="mt-1 text-sm text-gray-500">Tag code cannot be changed</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-paw mr-1 text-blue-600"></i> Pet</label>
                    @if($tag->pet)
                        <input type="text" value="{{ $tag->pet->name }} - {{ $tag->pet->customer->name }}" disabled
                            class="block w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm p-3 border text-base">
                    @else
                        <input type="text" value="Not assigned - Assign via mobile app" disabled
                            class="block w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm p-3 border text-amber-600 text-base">
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-info-circle mr-1 text-blue-600"></i> Status *</label>
                    <select name="status" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">
                        <option value="active" {{ old('status', $tag->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $tag->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="lost" {{ old('status', $tag->status) == 'lost' ? 'selected' : '' }}>Lost</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-sticky-note mr-1 text-blue-600"></i> Notes</label>
                    <textarea name="notes" rows="3"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-base">{{ old('notes', $tag->notes) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-2">
                <a href="{{ route('tags.show', $tag) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="bg-[#334da1] hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                    <i class="fas fa-save"></i> Update Tag
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
