<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\Treatment;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index(Customer $customer)
    {
        $pets = $customer->pets()->with('tag', 'treatments')->latest()->get();
        return view('pets.index', compact('customer', 'pets'));
    }

    public function create(Customer $customer)
    {
        return view('pets.create', compact('customer'));
    }

    public function store(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:male,female',
            'color' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'special_notes' => 'nullable|string',
        ]);

        $validated['customer_id'] = $customer->id;
        $customer->pets()->create($validated);

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Pet created successfully.');
    }

    public function show(Customer $customer, Pet $pet)
    {
        // Ensure pet belongs to customer
        if ($pet->customer_id !== $customer->id) {
            abort(404);
        }
        
        $pet->load(['treatments.user', 'treatments.collaborator', 'tag', 'bookings']);
        return view('pets.show', compact('customer', 'pet'));
    }

    public function edit(Customer $customer, Pet $pet)
    {
        // Ensure pet belongs to customer
        if ($pet->customer_id !== $customer->id) {
            abort(404);
        }
        
        return view('pets.edit', compact('customer', 'pet'));
    }

    public function update(Request $request, Customer $customer, Pet $pet)
    {
        // Ensure pet belongs to customer
        if ($pet->customer_id !== $customer->id) {
            abort(404);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:male,female',
            'color' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'special_notes' => 'nullable|string',
        ]);

        $pet->update($validated);

        return redirect()->route('customers.pets.show', [$customer, $pet])
            ->with('success', 'Pet updated successfully.');
    }

    public function destroy(Customer $customer, Pet $pet)
    {
        // Ensure pet belongs to customer
        if ($pet->customer_id !== $customer->id) {
            abort(404);
        }
        
        $pet->delete();

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Pet deleted successfully.');
    }

    public function addTreatment(Request $request, Customer $customer, Pet $pet)
    {
        // Ensure pet belongs to customer
        if ($pet->customer_id !== $customer->id) {
            abort(404);
        }
        
        $validated = $request->validate([
            'treatment_date' => 'required|date',
            'disease' => 'nullable|string|max:255',
            'diagnosis' => 'required|string',
            'treatment_given' => 'required|string',
            'medication' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['pet_id'] = $pet->id;
        $validated['user_id'] = auth()->id();
        $validated['treatment_location'] = auth()->user()->isCollaborator() ? 'collaborator' : 'government';
        
        if (auth()->user()->isCollaborator()) {
            $validated['collaborator_id'] = auth()->user()->collaborator_id;
        }

        Treatment::create($validated);

        return redirect()->route('customers.pets.show', [$customer, $pet])
            ->with('success', 'Treatment record added successfully.');
    }
}
