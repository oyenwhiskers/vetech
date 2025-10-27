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

        // Generate unique plain number tag code (4 digits)
        $tagCode = str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
        while (Tag::where('tag_code', $tagCode)->exists()) {
            $tagCode = str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
        }

        $validated['tag_code'] = $tagCode;
        $validated['status'] = 'active';

        // Use a free QR code API to generate the QR code URL
        $scanUrl = url('collaborator/scan/' . $tagCode);
        $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($scanUrl);
        $validated['qr_code_path'] = $qrApiUrl;

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
