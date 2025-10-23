@extends('layouts.vetech')

@section('title', 'Add Collaborator - VETech')
@section('header', 'Add New Collaborator')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('collaborators.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact Person Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Clinic Name *</label>
                    <input type="text" name="clinic_name" value="{{ old('clinic_name') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Address *</label>
                    <textarea name="address" rows="3" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">{{ old('address') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Registration Number *</label>
                    <input type="text" name="registration_number" value="{{ old('registration_number') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    <p class="mt-1 text-sm text-gray-500">Clinic registration or license number</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status *</label>
                    <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="border-t pt-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="create_account" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Create login account for this collaborator</span>
                    </label>
                    <p class="mt-1 text-sm text-gray-500">Default password will be: password123</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('collaborators.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Save Collaborator
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
