@extends('layouts.vetech')

@section('title', 'Customer Pets - VETech')
@section('header', $customer->name . "'s Pets")

@section('content')
<div class="mb-6">
    <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>Back to Customer
    </a>
</div>

<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-lg font-semibold">Pet Records for {{ $customer->name }}</h3>
        <p class="text-sm text-gray-600">{{ $pets->count() }} pet(s) registered</p>
    </div>
    <a href="{{ route('customers.pets.create', $customer) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i>Add New Pet
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($pets as $pet)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-semibold text-lg">{{ $pet->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $pet->species }} - {{ $pet->breed ?: 'Mixed' }}</p>
                </div>
                @if($pet->tag)
                    <span class="text-green-600"><i class="fas fa-qrcode"></i></span>
                @endif
            </div>
            
            <div class="space-y-2 text-sm">
                <p><i class="fas fa-venus-mars mr-2 text-gray-400"></i>{{ ucfirst($pet->gender) }}</p>
                @if($pet->age)
                    <p><i class="fas fa-birthday-cake mr-2 text-gray-400"></i>{{ $pet->age }} years old</p>
                @endif
                @if($pet->weight)
                    <p><i class="fas fa-weight mr-2 text-gray-400"></i>{{ $pet->weight }} kg</p>
                @endif
                <p><i class="fas fa-notes-medical mr-2 text-gray-400"></i>{{ $pet->treatments->count() }} treatment(s)</p>
            </div>
            
            <div class="mt-4 flex justify-end space-x-2">
                <a href="{{ route('customers.pets.show', [$customer, $pet]) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    View Details →
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12">
            <i class="fas fa-paw text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-500">No pets registered yet</p>
            <a href="{{ route('customers.pets.create', $customer) }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                Add the first pet →
            </a>
        </div>
    @endforelse
</div>
@endsection
