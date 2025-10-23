<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CollaboratorController extends Controller
{
    public function index()
    {
        $collaborators = Collaborator::withCount('treatments')->latest()->paginate(15);
        return view('collaborators.index', compact('collaborators'));
    }

    public function create()
    {
        return view('collaborators.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'clinic_name' => 'required|string|max:255',
            'email' => 'required|email|unique:collaborators,email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'registration_number' => 'required|string|unique:collaborators,registration_number|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $collaborator = Collaborator::create($validated);

        // Create user account for collaborator
        if ($request->has('create_account') && $request->create_account) {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($request->password ?? 'password123'),
                'role' => 'collaborator',
                'collaborator_id' => $collaborator->id,
            ]);
        }

        return redirect()->route('collaborators.index')
            ->with('success', 'Collaborator created successfully.');
    }

    public function show(Collaborator $collaborator)
    {
        $collaborator->load(['treatments.pet.customer', 'user']);
        return view('collaborators.show', compact('collaborator'));
    }

    public function edit(Collaborator $collaborator)
    {
        return view('collaborators.edit', compact('collaborator'));
    }

    public function update(Request $request, Collaborator $collaborator)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'clinic_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:collaborators,email,' . $collaborator->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'registration_number' => 'required|string|max:255|unique:collaborators,registration_number,' . $collaborator->id,
            'status' => 'required|in:active,inactive',
        ]);

        $collaborator->update($validated);

        return redirect()->route('collaborators.index')
            ->with('success', 'Collaborator updated successfully.');
    }

    public function destroy(Collaborator $collaborator)
    {
        // Delete associated user if exists
        if ($collaborator->user) {
            $collaborator->user->delete();
        }

        $collaborator->delete();

        return redirect()->route('collaborators.index')
            ->with('success', 'Collaborator deleted successfully.');
    }
}
