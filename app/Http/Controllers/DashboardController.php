<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Treatment;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalCustomers = Customer::count();
        $totalPets = Pet::count();
        $totalCollaborators = Collaborator::where('status', 'active')->count();
        $todayBookings = Booking::whereDate('booking_date', today())->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        
        // Recent bookings
        $recentBookings = Booking::with(['customer', 'pet'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Recent treatments
        $recentTreatments = Treatment::with(['pet.customer', 'user'])
            ->orderBy('treatment_date', 'desc')
            ->limit(5)
            ->get();
        
        // Monthly booking statistics
        $monthlyBookings = Booking::select(
            DB::raw('DATE_FORMAT(booking_date, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('booking_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('dashboard', compact(
            'totalCustomers',
            'totalPets',
            'totalCollaborators',
            'todayBookings',
            'pendingBookings',
            'recentBookings',
            'recentTreatments',
            'monthlyBookings'
        ));
    }
}
