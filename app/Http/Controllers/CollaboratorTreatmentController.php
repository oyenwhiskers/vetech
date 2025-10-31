<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Pet;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollaboratorTreatmentController extends Controller
{
    /**
     * Display QR scanner page for collaborators.
     */
    public function scanner()
    {
        return view('collaborator.scanner');
    }

    /**
     * Scan a tag and view pet details.
     */
    public function scan($tagCode)
    {
        $tag = Tag::where('tag_code', $tagCode)
            ->with(['pet.customer', 'pet.treatments' => function($query) {
                $query->with(['user', 'collaborator', 'deleter'])
                      ->withTrashed()
                      ->orderBy('treatment_date', 'desc');
            }])
            ->first();

        // Handle not found
        if (!$tag) {
            return redirect()->back()->with('error', 'Tag not found.');
        }

        // Ensure active status
        if ($tag->status !== 'active') {
            return redirect()->back()->with('error', 'Tag is not active.');
        }

        // Ensure the tag is assigned to a pet
        if (empty($tag->pet)) {
            return redirect()->back()->with('error', 'Tag is not assigned.');
        }

        return view('collaborator.scan-result', compact('tag'));
    }

    /**
     * Display list of all treatments done by this collaborator.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Allow access if user is a collaborator role (even if collaborator_id is null for now)
        if (!$user->isCollaborator()) {
            abort(403, 'Unauthorized access. Collaborator role required.');
        }

        $treatments = Treatment::with(['pet.customer', 'pet', 'collaborator'])
            ->where('user_id', $user->id)
            ->withTrashed()
            ->orderBy('treatment_date', 'desc')
            ->paginate(20);

        return view('collaborator.treatments.index', compact('treatments'));
    }

    /**
     * Show form to add treatment to a pet.
     */
    public function create(Pet $pet)
    {
        $pet->load('customer');
        return view('collaborator.treatments.create', compact('pet'));
    }

    /**
     * Store a new treatment record.
     */
    public function store(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'treatment_date' => 'required|date',
            'treated_by' => 'nullable|string|max:255',
            'disease' => 'nullable|string|max:255',
            'diagnosis' => 'required|string',
            'treatment_given' => 'required|string',
            'medication' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'temperature' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
        ]);

        $user = Auth::user();
        
        $validated['pet_id'] = $pet->id;
        $validated['user_id'] = $user->id;
        $validated['treatment_location'] = 'collaborator';
        $validated['collaborator_id'] = $user->collaborator_id;

        Treatment::create($validated);

        return redirect()->route('collaborator.treatments.index')
            ->with('success', 'Treatment record added successfully.');
    }

    /**
     * Display a specific treatment (read-only if not owner).
     */
    public function show(Treatment $treatment)
    {
        $treatment->load(['pet.customer', 'user', 'collaborator', 'deleter']);
        $canDelete = $treatment->canBeDeletedBy(Auth::user()) && !$treatment->trashed();

        if (request()->ajax()) {
            return view('collaborator.treatments.partials.show-modal', compact('treatment', 'canDelete'));
        }

        return view('collaborator.treatments.show', compact('treatment', 'canDelete'));
    }

    /**
     * Soft delete a treatment (only own records).
     */
    public function destroy(Treatment $treatment)
    {
        $user = Auth::user();
        
        if (!$treatment->canBeDeletedBy($user)) {
            return redirect()->back()
                ->with('error', 'You can only delete your own treatment records.');
        }

        if ($treatment->trashed()) {
            return redirect()->back()
                ->with('error', 'This treatment has already been deleted.');
        }

        $treatment->deleted_by = $user->id;
        $treatment->save();
        $treatment->delete();

        return redirect()->route('collaborator.treatments.index')
            ->with('success', 'Treatment record moved to delete log.');
    }

    /**
     * View deleted treatments log.
     */
    public function deletedLog()
    {
        $user = Auth::user();
        
        $deletedTreatments = Treatment::onlyTrashed()
            ->with(['pet.customer', 'user', 'collaborator', 'deleter'])
            ->where('user_id', $user->id)
            ->orderBy('deleted_at', 'desc')
            ->paginate(20);

        return view('collaborator.treatments.deleted-log', compact('deletedTreatments'));
    }
}
