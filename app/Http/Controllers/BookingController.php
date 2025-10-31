<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'pet']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('booking_date', $request->date);
        }

        $bookings = $query->orderBy('booking_date')->orderBy('booking_time')->paginate(15);

        // Calculate metrics
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $completedBookings = Booking::where('status', 'completed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();
        $todayBookings = Booking::whereDate('booking_date', today())->count();

        return view('bookings.index', compact(
            'bookings',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'completedBookings',
            'cancelledBookings',
            'todayBookings'
        ));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $pets = Pet::with('customer')->orderBy('name')->get();
        return view('bookings.create', compact('customers', 'pets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'pet_id' => 'required|exists:pets,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'service_type' => 'required|string|max:255',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'confirmed';

        // must have a user who is booking the appointment
        $validated['booking_by'] = Auth::user()->id;
        // Generate queue number for the day
        // $lastQueue = Booking::whereDate('booking_date', $validated['booking_date'])
        //     ->max('queue_number');
        // $validated['queue_number'] = $lastQueue ? $lastQueue + 1 : 1;

        Booking::create($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['customer', 'pet']);
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        if ($booking->booking_by !== Auth::id()) {
            abort(403, 'You are not authorized to edit this booking.');
        }
        $customers = Customer::orderBy('name')->get();
        $pets = Pet::with('customer')->orderBy('name')->get();
        return view('bookings.edit', compact('booking', 'customers', 'pets'));
    }

    public function update(Request $request, Booking $booking)
    {
        if ($booking->booking_by !== Auth::id()) {
            abort(403, 'You are not authorized to update this booking.');
        }
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'pet_id' => 'required|exists:pets,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'service_type' => 'required|string|max:255',
            'reason' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $booking->update($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->booking_by !== Auth::id()) {
            abort(403, 'You are not authorized to delete this booking.');
        }
        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        if ($booking->booking_by !== Auth::id()) {
            abort(403, 'You are not authorized to modify this booking status.');
        }
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update($validated);

        return redirect()->back()
            ->with('success', 'Booking status updated successfully.');
    }
}
