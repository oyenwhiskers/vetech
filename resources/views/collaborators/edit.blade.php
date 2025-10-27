@extends('layouts.vetech')

@section('title', 'Edit Collaborator - VETech')
@section('header', 'Edit Collaborator')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('collaborators.update', $collaborator) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact Person Name *</label>
                    <input type="text" name="name" value="{{ old('name', $collaborator->name) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Clinic Name *</label>
                    <input type="text" name="clinic_name" value="{{ old('clinic_name', $collaborator->clinic_name) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $collaborator->email) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone *</label>
                    <input type="text" name="phone" value="{{ old('phone', $collaborator->phone) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Address *</label>
                    <textarea name="address" rows="3" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">{{ old('address', $collaborator->address) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Registration Number *</label>
                    <input type="text" name="registration_number" value="{{ old('registration_number', $collaborator->registration_number) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status *</label>
                    <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        <option value="active" {{ old('status', $collaborator->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $collaborator->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('collaborators.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Update Collaborator
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
