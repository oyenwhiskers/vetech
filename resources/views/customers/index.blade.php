@extends('layouts.vetech')

@section('title', 'Customers - VETech')
@section('header', 'Manage Customers')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-lg font-semibold">Customer Records</h3>
        <p class="text-sm text-gray-600">Manage all customer information</p>
    </div>
    <a href="{{ route('customers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i>Add New Customer
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC Number</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pets</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($customers as $customer)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                    <div class="text-sm text-gray-500">{{ $customer->email }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $customer->ic_number }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $customer->phone }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        {{ $customer->pets_count }} {{ Str::plural('pet', $customer->pets_count) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('customers.edit', $customer) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No customers found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $customers->links() }}
</div>
@endsection
