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
    public function index()
    {
        $tags = Tag::with('pet.customer')->latest()->paginate(15);
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
            'pet_id' => 'required|exists:pets,id|unique:tags,pet_id',
            'issued_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Generate unique tag code
        $tagCode = 'VET-' . strtoupper(Str::random(8));
        while (Tag::where('tag_code', $tagCode)->exists()) {
            $tagCode = 'VET-' . strtoupper(Str::random(8));
        }

        $validated['tag_code'] = $tagCode;
        $validated['status'] = 'active';

        // Generate QR Code
        $qrCode = QrCode::create(route('tags.scan', $tagCode))
            ->setSize(300);
        
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Save QR Code
        $fileName = 'qrcodes/' . $tagCode . '.png';
        Storage::disk('public')->put($fileName, $result->getString());
        $validated['qr_code_path'] = $fileName;

        Tag::create($validated);

        return redirect()->route('tags.index')
            ->with('success', 'Tag created successfully.');
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
        // Delete QR code file
        if ($tag->qr_code_path) {
            Storage::disk('public')->delete($tag->qr_code_path);
        }

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
        if (!$tag->qr_code_path || !Storage::disk('public')->exists($tag->qr_code_path)) {
            return redirect()->back()->with('error', 'QR Code not found.');
        }

        return Storage::disk('public')->download($tag->qr_code_path, $tag->tag_code . '.png');
    }
}
