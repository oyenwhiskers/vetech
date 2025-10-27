@extends('layouts.vetech')

@section('title', 'Collaborator Details - VETech')
@section('header', 'Collaborator Details')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h3 class="text-xl font-semibold text-gray-900">{{ $collaborator->clinic_name }}</h3>
        <p class="text-sm text-gray-600">Managed by {{ $collaborator->name }}</p>
    </div>
    <div class="flex items-center gap-2">
        <span class="px-2 py-1 text-xs rounded-full {{ $collaborator->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
            {{ ucfirst($collaborator->status) }}
        </span>
        <a href="{{ route('collaborators.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
        <a href="{{ route('collaborators.edit', $collaborator) }}" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
            <i class="fas fa-edit mr-1"></i> Edit
        </a>
    </div>
</div>

<!-- Top cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-center justify-between mb-2">
            <h4 class="font-semibold text-gray-900">Registration</h4>
            <i class="fas fa-id-card text-blue-600"></i>
        </div>
        <p class="text-sm text-gray-600 break-all">{{ $collaborator->registration_number }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-center justify-between mb-2">
            <h4 class="font-semibold text-gray-900">Contact</h4>
            <i class="fas fa-phone text-blue-600"></i>
        </div>
        <p class="text-sm text-gray-700"><i class="fas fa-envelope text-gray-400 mr-2"></i>{{ $collaborator->email }}</p>
        <p class="text-sm text-gray-700"><i class="fas fa-phone text-gray-400 mr-2"></i>{{ $collaborator->phone }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-center justify-between mb-2">
            <h4 class="font-semibold text-gray-900">Treatments</h4>
            <i class="fas fa-notes-medical text-blue-600"></i>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $collaborator->treatments->count() }}</p>
        <p class="text-xs text-gray-500">Total treatments recorded</p>
    </div>
</div>

<!-- Address and Linked User -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-5">
        <h4 class="font-semibold text-gray-900 mb-2"><i class="fas fa-location-dot text-blue-600 mr-2"></i>Address</h4>
        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $collaborator->address }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <h4 class="font-semibold text-gray-900 mb-2"><i class="fas fa-user text-blue-600 mr-2"></i>Linked User Account</h4>
        @if($collaborator->user)
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $collaborator->user->name }}</p>
                    <p class="text-xs text-gray-600">{{ $collaborator->user->email }}</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full {{ $collaborator->user->role === 'collaborator' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                    {{ ucfirst($collaborator->user->role) }}
                </span>
            </div>
        @else
            <p class="text-sm text-gray-600">No user account linked.</p>
        @endif
    </div>
</div>

<!-- Recent Treatments -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-5 py-3 border-b">
        <h4 class="font-semibold text-gray-900"><i class="fas fa-history text-blue-600 mr-2"></i>Recent Treatments</h4>
    </div>
    @php($recent = $collaborator->treatments->sortByDesc('treatment_date')->take(10))
    @if($recent->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pet</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Owner</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Diagnosis</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Location</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recent as $t)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ optional($t->treatment_date)->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ optional($t->pet)->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ optional(optional($t->pet)->customer)->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($t->diagnosis, 60) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $t->treatment_location == 'clinic' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($t->treatment_location) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-6 text-center text-gray-500">
            No treatment data yet for this collaborator.
        </div>
    @endif
</div>
@endsection
