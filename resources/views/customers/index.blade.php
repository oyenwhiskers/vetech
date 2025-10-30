@extends('layouts.vetech')

@section('title', 'Customers - VETech')
@section('header', 'Manage Customers')

@section('content')
<div x-data="{ 
        open: false, 
        selected: null,
        searchQuery: '',
        hasVisibleRows() {
            if (!this.searchQuery) return true;
            const rows = document.querySelectorAll('tbody tr[data-customer]');
            return Array.from(rows).some(row => {
                const name = row.dataset.name || '';
                const ic = row.dataset.ic || '';
                const phone = row.dataset.phone || '';
                const email = row.dataset.email || '';
                const query = this.searchQuery.toLowerCase();
                return name.includes(query) || ic.includes(query) || phone.includes(query) || email.includes(query);
            });
        }
    }" id="customerModal"
    x-on:open-customer-modal.window="selected = $event.detail.customer; open = true">

<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h3 class="text-lg font-semibold">Customer Records</h3>
        <p class="text-sm text-gray-600">Manage all customer information</p>
    </div>
    <a href="{{ route('customers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i>Add New Customer
    </a>
</div>

<!-- Filter Bar -->
<div class="mb-6 bg-white rounded-lg shadow p-4">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <div class="relative">
                <input 
                    type="text" 
                    x-model="searchQuery"
                    placeholder="Search by name, IC number, phone, or email..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
        <button 
            @click="searchQuery = ''" 
            x-show="searchQuery.length > 0"
            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors flex items-center gap-2"
        >
            <i class="fas fa-times"></i> Clear
        </button>
    </div>
</div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pets</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($customers as $customer)
                <tr data-customer
                    data-name="{{ strtolower($customer->name) }}"
                    data-ic="{{ strtolower($customer->ic_number) }}"
                    data-phone="{{ strtolower($customer->phone) }}"
                    data-email="{{ strtolower($customer->email ?? '') }}"
                    x-show="!searchQuery || 
                        $el.dataset.name.includes(searchQuery.toLowerCase()) || 
                        $el.dataset.ic.includes(searchQuery.toLowerCase()) || 
                        $el.dataset.phone.includes(searchQuery.toLowerCase()) || 
                        $el.dataset.email.includes(searchQuery.toLowerCase())"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                        <button @click="open = true; selected = {{ Js::from($customer) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </button>
                        <a href="{{ route('customers.edit', $customer) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button @click="$dispatch('open-delete-modal', {id: {{ $customer->id }}, name: '{{ addslashes($customer->name) }}'})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr x-show="!searchQuery">
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No customers found</td>
                </tr>
                @endforelse
                
                <!-- No Search Results Row -->
                <tr x-show="searchQuery && !hasVisibleRows()" x-transition>
                    <td colspan="5" class="px-6 py-8 text-center">
                        <i class="fas fa-search text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">No customers match your search</p>
                        <p class="text-gray-400 text-sm mt-1">Try adjusting your search terms</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Reusable Modal -->
    <template x-if="open && selected && selected.id">
        <div @click.self="open = false; selected = null" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" x-transition>
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-[#c1eaf7] to-[#8fd3e6] px-6 py-4 rounded-t-2xl flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-[#222]">
                        <i class="fas fa-user-circle mr-2"></i>Customer Information
                    </h3>
                    <button @click="open = false; selected = null" class="text-[#222] hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <!-- Customer Details Grid -->

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">
                            <i class="fas fa-user-circle mr-1"></i>Profile Image
                        </p>
                        <div class="flex justify-center items-center">
                            <img :src="selected && selected.profile_image
                                ? (selected.profile_image.startsWith('http') || selected.profile_image.startsWith('/storage/')
                                    ? selected.profile_image
                                    : ('{{ asset('storage') }}' + '/' + (selected.profile_image || '').replace(/^\/?storage\//,'').replace(/^\//,'')))
                                : 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png?20150327203541'"
                                alt="Customer Profile Image" class="w-24 h-24 rounded-full object-cover">
                        </div>
                    </div>
                    <br>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1">
                                <i class="fas fa-user mr-1"></i>Name
                            </p>
                            <p class="text-lg font-bold text-gray-900" x-text="selected.name"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1">
                                <i class="fas fa-id-card mr-1"></i>IC Number
                            </p>
                            <p class="text-lg font-bold text-gray-900" x-text="selected.ic_number"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1">
                                <i class="fas fa-envelope mr-1"></i>Email
                            </p>
                            <p class="text-base text-gray-900" x-text="selected.email ? selected.email : 'N/A'"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1">
                                <i class="fas fa-phone mr-1"></i>Phone
                            </p>
                            <p class="text-base text-gray-900" x-text="selected.phone"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1">
                                <i class="fas fa-map-marker-alt mr-1"></i>Address
                            </p>
                            <p class="text-base text-gray-900" x-text="selected.address ? selected.address : 'N/A'"></p>
                        </div>
                    </div>

                    <!-- Pets Section -->
                    <div class="border-t pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-xl font-bold text-gray-900">
                                <i class="fas fa-paw mr-2 text-[#334da1]"></i>Pets
                            </h4>
                            <span class="bg-[#334da1] text-white px-3 py-1 rounded-full text-sm font-semibold" x-text="selected.pets ? selected.pets.length : 0"></span>
                        </div>
                        
                        <div class="space-y-3 mb-4">
                            <template x-if="selected.pets && selected.pets.length">
                                <template x-for="pet in selected.pets" :key="pet.id">
                                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between gap-3">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-3">
                                                    <i class="fas fa-paw text-[#334da1]"></i>
                                                    <h5 class="text-lg font-bold text-gray-900" x-text="pet.name"></h5>
                                                </div>
                                                <div class="flex flex-wrap gap-x-4 gap-y-2">
                                                    <p class="text-sm text-gray-700 flex items-center gap-1">
                                                        <i class="fas fa-info-circle text-gray-500"></i>
                                                        <span x-text="pet.species + ' - ' + (pet.breed || 'Unknown breed')"></span>
                                                    </p>
                                                    <p class="text-sm text-gray-700 flex items-center gap-1" x-show="pet.gender">
                                                        <i class="fas fa-venus-mars text-gray-500"></i>
                                                        <span x-text="pet.gender ? pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1) : ''"></span>
                                                    </p>
                                                    <p class="text-sm text-gray-700 flex items-center gap-1" x-show="pet.age">
                                                        <i class="fas fa-hourglass-half text-gray-500"></i>
                                                        <span x-text="pet.age + ' years old'"></span>
                                                    </p>
                                                    <p class="text-sm text-gray-700 flex items-center gap-1" x-show="pet.color">
                                                        <i class="fas fa-palette text-gray-500"></i>
                                                        <span x-text="pet.color"></span>
                                                    </p>
                                                    <p class="text-sm text-gray-700 flex items-center gap-1" x-show="pet.weight">
                                                        <i class="fas fa-weight text-gray-500"></i>
                                                        <span x-text="pet.weight + ' kg'"></span>
                                                    </p>
                                                    <p class="text-sm text-gray-700 flex items-center gap-1" x-show="pet.tag">
                                                        <i class="fas fa-qrcode text-gray-500"></i>
                                                        <span>Tag: <strong x-text="pet.tag ? pet.tag.tag_code : 'N/A'"></strong></span>
                                                    </p>
                                                </div>
                                            </div>
                                            <a :href="'/customers/' + selected.id + '/pets/' + pet.id" class="flex-shrink-0 bg-[#334da1] hover:bg-[#2a3d85] text-white px-3 py-2 rounded-lg transition-colors text-sm font-medium">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>
                                        </div>
                                    </div>
                                </template>
                            </template>
                            <template x-if="!selected.pets || !selected.pets.length">
                                <div class="text-center py-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                    <i class="fas fa-paw text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500 font-medium">No pets registered yet</p>
                                </div>
                            </template>
                        </div>

                        <!-- Add Pet Button -->
                        <a :href="'/customers/' + selected.id + '/pets/create'" class="block w-full bg-[#334da1] hover:bg-[#2a3d85] text-white font-semibold py-3 px-4 rounded-lg transition-colors text-center">
                            <i class="fas fa-plus mr-2"></i>Add Pet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </template>

<!-- Delete Confirmation Modal -->
<div x-data="{ open: false, customerId: null, customerName: '' }"
     x-on:open-delete-modal.window="customerId = $event.detail.id; customerName = $event.detail.name; open = true">
    <template x-if="open">
        <div @click.self="open = false" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8" x-transition>
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-red-600 text-white rounded-full flex items-center justify-center w-12 h-12">
                        <i class="fas fa-trash-alt text-2xl"></i>
                    </span>
                    <h3 class="text-xl font-bold text-red-700">Delete Customer</h3>
                </div>
                <p class="mb-6 text-gray-700">Are you sure you want to delete <span class="font-semibold" x-text="customerName"></span>? This action cannot be undone and will remove all related pets and records.</p>
                <form :action="'/customers/' + customerId" method="POST" @submit.prevent="if($el.checkValidity()){ $el.submit(); open = false; }">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-3 mt-4">
                        <button type="button" @click="open = false" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>

<div class="mt-6">
    {{ $customers->links() }}
</div>

</div>

@if(request()->has('view'))
<script>
window.addEventListener('load', function() {
    // Wait a bit longer for Alpine to be fully ready
    setTimeout(() => {
        const viewCustomerId = '{{ request()->get("view") }}';
        const customers = @json($customers->items());
        const customer = customers.find(c => c.id == viewCustomerId);
        
        if (customer) {
            const modalDiv = document.getElementById('customerModal');
            if (modalDiv) {
                // Always dispatch custom event for Alpine
                window.dispatchEvent(new CustomEvent('open-customer-modal', { detail: { customer: customer } }));
                // Clean URL
                window.history.replaceState({}, '', '{{ route("customers.index") }}');
            }
        }
    }, 300);
});
</script>
@endif
@endsection
