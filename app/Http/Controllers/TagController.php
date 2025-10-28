<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

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
            // Generate unique plain number tag code (4 digits)
            $tagCode = str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
            while (Tag::where('tag_code', $tagCode)->exists()) {
                $tagCode = str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
            }

            $tagData = [
                'tag_code' => $tagCode,
                'pet_id' => ($i == 0 && !empty($validated['pet_id'])) ? $validated['pet_id'] : null,
                'issued_date' => $validated['issued_date'],
                'notes' => $validated['notes'],
                'status' => 'active',
            ];

            // Generate QR code with ONLY the tag number (not a URL)
            // Generic scanners will show just the number
            // Custom mobile app scanner will append the correct URL
            $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($tagCode);
            $tagData['qr_code_path'] = $qrApiUrl;

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

        return view('tags.scan', compact('tag'));
    }

    public function download(Tag $tag)
    {
        if (!$tag->qr_code_path) {
            return redirect()->back()->with('error', 'QR Code not found.');
        }
    
        // Handle external QR code URLs
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
    
        // Local storage fallback
        if (!Storage::disk('public')->exists($tag->qr_code_path)) {
            return redirect()->back()->with('error', 'QR Code not found.');
        }
    
        return Storage::disk('public')->download($tag->qr_code_path, $tag->tag_code.'.png');
    }
}
