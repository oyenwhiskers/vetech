@extends('layouts.vetech')

@section('title', 'Edit Tag - VETech')
@section('header', 'Edit Tag')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('tags.update', $tag) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tag Code</label>
                    <input type="text" value="{{ $tag->tag_code }}" disabled
                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm p-2 border">
                    <p class="mt-1 text-sm text-gray-500">Tag code cannot be changed</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Pet</label>
                    @if($tag->pet)
                        <input type="text" value="{{ $tag->pet->name }} - {{ $tag->pet->customer->name }}" disabled
                            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm p-2 border">
                    @else
                        <input type="text" value="Not assigned - Assign via mobile app" disabled
                            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm p-2 border text-amber-600">
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status *</label>
                    <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        <option value="active" {{ old('status', $tag->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $tag->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="lost" {{ old('status', $tag->status) == 'lost' ? 'selected' : '' }}>Lost</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">{{ old('notes', $tag->notes) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('tags.show', $tag) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Update Tag
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
