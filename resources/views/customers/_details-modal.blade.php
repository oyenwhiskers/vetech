<!-- Customer Details Modal -->
<div x-data="{ open: false }" @keydown.escape.window="open = false">
    <button @click="open = true" class="text-blue-600 hover:text-blue-900 mr-3">
        <i class="fas fa-eye"></i>
    </button>
    <div x-show="open" @click.self="open = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6 relative">
            <button @click="open = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
            <h3 class="text-xl font-bold mb-2">Customer Information</h3>
            <div class="mb-4">
                <p class="text-sm text-gray-500">Profile Image</p>
                <img src="{{ $customer->profile_image ? asset('storage/' . $customer->profile_image) : 'https://via.placeholder.com/150' }}" alt="Customer Profile Image" class="w-24 h-24 rounded-full object-cover">
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-500">Name</p>
                <p class="font-semibold">{{ $customer->name }}</p>
                <p class="text-sm text-gray-500">IC Number</p>
                <p class="font-semibold">{{ $customer->ic_number }}</p>
                <p class="text-sm text-gray-500">Email</p>
                <p>{{ $customer->email ?: 'N/A' }}</p>
                <p class="text-sm text-gray-500">Phone</p>
                <p>{{ $customer->phone }}</p>
                <p class="text-sm text-gray-500">Address</p>
                <p>{{ $customer->address ?: 'N/A' }}</p>
            </div>
            <h4 class="text-lg font-semibold mb-2">Pets ({{ $customer->pets->count() }})</h4>
            <div class="space-y-2 mb-4">
                @forelse($customer->pets as $pet)
                    <div class="border rounded p-2">
                        <div class="font-semibold">{{ $pet->name }}</div>
                        <div class="text-sm text-gray-600">{{ $pet->species }} - {{ $pet->breed }}</div>
                    </div>
                @empty
                    <div class="text-gray-500">No pets registered.</div>
                @endforelse
            </div>
            <a href="{{ route('customers.pets.create', $customer) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                <i class="fas fa-plus mr-2"></i>Add Pet
            </a>
        </div>
    </div>
</div>
