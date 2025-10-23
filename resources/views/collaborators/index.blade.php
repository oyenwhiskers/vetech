@extends('layouts.vetech')

@section('title', 'Collaborators - VETech')
@section('header', 'Manage Collaborators')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-lg font-semibold">Collaborator Clinics</h3>
        <p class="text-sm text-gray-600">Manage private clinic partnerships</p>
    </div>
    <a href="{{ route('collaborators.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i>Add Collaborator
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($collaborators as $collaborator)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-semibold text-lg">{{ $collaborator->clinic_name }}</h4>
                    <p class="text-sm text-gray-600">{{ $collaborator->name }}</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full {{ $collaborator->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($collaborator->status) }}
                </span>
            </div>

            <div class="space-y-2 text-sm mb-4">
                <p><i class="fas fa-envelope text-gray-400 mr-2"></i>{{ $collaborator->email }}</p>
                <p><i class="fas fa-phone text-gray-400 mr-2"></i>{{ $collaborator->phone }}</p>
                <p><i class="fas fa-id-card text-gray-400 mr-2"></i>{{ $collaborator->registration_number }}</p>
                <p><i class="fas fa-notes-medical text-gray-400 mr-2"></i>{{ $collaborator->treatments_count }} treatments</p>
            </div>

            <div class="flex justify-between items-center pt-4 border-t">
                <a href="{{ route('collaborators.show', $collaborator) }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-eye"></i> View
                </a>
                <a href="{{ route('collaborators.edit', $collaborator) }}" class="text-yellow-600 hover:text-yellow-800">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('collaborators.destroy', $collaborator) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12 text-gray-500">
            No collaborators registered yet
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $collaborators->links() }}
</div>
@endsection
