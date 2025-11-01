<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\QrGeneratorController;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $query = Tag::with('pet.customer');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tag_code', 'like', "%{$search}%")
                  ->orWhereHas('pet', function($petQuery) use ($search) {
                      $petQuery->where('name', 'like', "%{$search}%")
                               ->orWhereHas('customer', function($customerQuery) use ($search) {
                                   $customerQuery->where('name', 'like', "%{$search}%");
                               });
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Assignment filter (assigned/unassigned)
        if ($request->filled('assignment')) {
            if ($request->assignment === 'assigned') {
                $query->whereNotNull('pet_id');
            } elseif ($request->assignment === 'unassigned') {
                $query->whereNull('pet_id');
            }
        }

        $tags = $query->latest()->paginate(15)->withQueryString();
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        $pets = Pet::with('customer')
            ->whereDoesntHave('tag')
            ->orderBy('name')
            ->get();
        return view('tags.create', compact('pets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'nullable|exists:pets,id|unique:tags,pet_id',
            'issued_date' => 'required|date',
            'quantity' => 'required|integer|min:1|max:50',
            'notes' => 'nullable|string',
        ]);

        $quantity = $validated['quantity'];
        $createdTags = [];

        for ($i = 0; $i < $quantity; $i++) {
            // Check the current highest tag code
            $highestTag = Tag::orderBy('tag_code', 'desc')->first();
            if ($highestTag) {
                $tagCode = $highestTag->tag_code + 1;
            } else {
                $tagCode = 1000;
            }

            $tagData = [
                'tag_code' => $tagCode,
                'pet_id' => ($i == 0 && !empty($validated['pet_id'])) ? $validated['pet_id'] : null,
                'issued_date' => $validated['issued_date'],
                'notes' => $validated['notes'],
                'status' => 'active',
            ];

            // Generate and locally store QR code with ONLY the tag number
            $qrPublicUrl = QrGeneratorController::generateQrCodeAndSave($tagCode, 500, $tagCode.'.png');
            $tagData['qr_code_path'] = $qrPublicUrl;

            $createdTags[] = Tag::create($tagData);
        }

        $message = $quantity == 1 
            ? 'Tag created successfully.' 
            : "{$quantity} tags created successfully.";

        return redirect()->route('tags.index')
            ->with('success', $message);
    }

    public function show(Tag $tag)
    {
        $tag->load(['pet.customer', 'pet.treatments']);
        return view('tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive,lost',
            'notes' => 'nullable|string',
        ]);

        $tag->update($validated);

        return redirect()->route('tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {


        $tag->delete();

        return redirect()->route('tags.index')
            ->with('success', 'Tag deleted successfully.');
    }

    public function scan($tagCode)
    {
        $tag = Tag::where('tag_code', $tagCode)
            ->with(['pet.customer', 'pet.treatments.user', 'pet.treatments.collaborator'])
            ->firstOrFail();

        // Ensure the tag is assigned to a pet before proceeding
        if (empty($tag->pet)) {
            return redirect()->back()->with('error', 'Tag is not assigned.');
        }

        if ($tag->status !== 'active') {
            return redirect()->back()->with('error', 'Tag is not active.');
        }

        return view('tags.scan', compact('tag'));
    }

    public function download(Tag $tag)
    {
        if (empty($tag->qr_code_path)) {
            return redirect()->back()->with('error', 'QR Code not found.');
        }

        // Handle external QR code URLs (legacy/external support)
        if (Str::startsWith($tag->qr_code_path, ['http://', 'https://'])) {
            $ch = curl_init($tag->qr_code_path);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $imageContent = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($imageContent === false || $httpCode !== 200) {
                return redirect()->back()->with('error', 'Unable to download QR Code.');
            }

            return response($imageContent)
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', 'attachment; filename="'.$tag->tag_code.'.png"');
        }

        // For local storage, ensure qr_code_path is relative to the 'public' disk (e.g., 'qrcodes/123.png')
        $path = $tag->qr_code_path;
        // If stored as full URL, remove base URL prefix
        $path = str_replace(url('storage/'), '', $path);
        // If stored with 'storage/' prefix, strip it as the disk root is already 'public'
        if (Str::startsWith($path, 'storage/')) {
            $path = Str::after($path, 'storage/');
        }
        $relativePath = ltrim($path, '/');

        if (!Storage::disk('public')->exists($relativePath)) {
            return redirect()->back()->with('error', 'QR Code not found.');
        }

        $absolutePath = Storage::disk('public')->path($relativePath);
        return response()->download($absolutePath, $tag->tag_code.'.png', [
            'Content-Type' => 'image/png',
        ]);
    }
}
