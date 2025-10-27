@extends('layouts.vetech')

@section('title', 'Customer Details - VETech')
@section('header', 'Customer Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('customers.index') }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>Back to Customers
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Customer Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-semibold">Customer Information</h3>
                <a href="{{ route('customers.edit', $customer) }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="font-semibold">{{ $customer->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">IC Number</p>
                    <p class="font-semibold">{{ $customer->ic_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p>{{ $customer->email ?: 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p>{{ $customer->phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Address</p>
                    <p>{{ $customer->address ?: 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pets List -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Pets ({{ $customer->pets->count() }})</h3>
                <a href="{{ route('customers.pets.create', $customer) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-plus mr-2"></i>Add Pet
                </a>
            </div>

            @if($customer->pets->count() > 0)
                <div class="space-y-4">
                    @foreach($customer->pets as $pet)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-lg">{{ $pet->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $pet->species }} - {{ $pet->breed }}</p>
                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-600">
                                        <span><i class="fas fa-venus-mars mr-1"></i>{{ ucfirst($pet->gender) }}</span>
                                        @if($pet->age)
                                            <span><i class="fas fa-hourglass-half mr-1"></i>{{ $pet->age }} years old</span>
                                        @endif
                                        @if($pet->weight)
                                            <span><i class="fas fa-weight mr-1"></i>{{ $pet->weight }} kg</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <span class="text-sm text-gray-600">
                                            <i class="fas fa-notes-medical mr-1"></i>
                                            {{ $pet->treatments->count() }} treatment(s)
                                        </span>
                                        @if($pet->tag)
                                            <span class="ml-3 text-sm">
                                                <i class="fas fa-qrcode mr-1 text-green-600"></i>
                                                Tagged
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('customers.pets.show', [$customer, $pet]) }}" class="text-blue-600 hover:text-blue-800">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No pets registered yet</p>
            @endif
        </div>
    </div>
</div>
@endsection
