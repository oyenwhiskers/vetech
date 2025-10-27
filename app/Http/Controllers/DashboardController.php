<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Treatment;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Check if user is a collaborator
        if ($user->isCollaborator()) {
            return $this->collaboratorDashboard();
        }
        
        // Admin dashboard
        return $this->adminDashboard();
    }
    
    /**
     * Dashboard for collaborators - focused on their treatment activities
     */
    private function collaboratorDashboard()
    {
        $user = Auth::user();
        
        // Collaborator-specific statistics
        $myTreatmentsTotal = Treatment::where('user_id', $user->id)->count();
        $myTreatmentsThisMonth = Treatment::where('user_id', $user->id)
            ->whereMonth('treatment_date', now()->month)
            ->whereYear('treatment_date', now()->year)
            ->count();
        $myTreatmentsToday = Treatment::where('user_id', $user->id)
            ->whereDate('treatment_date', today())
            ->count();
        $myDeletedTreatments = Treatment::where('user_id', $user->id)
            ->onlyTrashed()
            ->count();
        
        // Recent treatments by this collaborator
        $myRecentTreatments = Treatment::with(['pet.customer', 'user'])
            ->where('user_id', $user->id)
            ->orderBy('treatment_date', 'desc')
            ->limit(10)
            ->get();
        
        // Treatment statistics by month (last 6 months)
        $monthlyTreatments = Treatment::select(
            DB::raw('DATE_FORMAT(treatment_date, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('user_id', $user->id)
            ->where('treatment_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Most treated species
        $speciesStats = Treatment::select('pets.species', DB::raw('COUNT(*) as count'))
            ->join('pets', 'treatments.pet_id', '=', 'pets.id')
            ->where('treatments.user_id', $user->id)
            ->groupBy('pets.species')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
        
        // Treatment location breakdown
        $locationStats = Treatment::select('treatment_location', DB::raw('COUNT(*) as count'))
            ->where('user_id', $user->id)
            ->groupBy('treatment_location')
            ->get();
        
        return view('dashboard-collaborator', compact(
            'myTreatmentsTotal',
            'myTreatmentsThisMonth',
            'myTreatmentsToday',
            'myDeletedTreatments',
            'myRecentTreatments',
            'monthlyTreatments',
            'speciesStats',
            'locationStats'
        ));
    }
    
    /**
     * Dashboard for administrators - full system overview
     */
    private function adminDashboard()
    {
        // Get statistics
        $totalCustomers = Customer::count();
        $totalPets = Pet::count();
        $totalCollaborators = Collaborator::where('status', 'active')->count();
        $todayBookings = Booking::whereDate('booking_date', today())->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalTreatments = Treatment::count();
        $totalTags = \App\Models\Tag::count();
        $unassignedTags = \App\Models\Tag::whereNull('pet_id')->count();
        
        // Booking status breakdown
        $bookingStatusStats = Booking::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
        
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
        
        // Monthly booking statistics (last 6 months)
        $monthlyBookings = Booking::select(
            DB::raw('DATE_FORMAT(booking_date, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('booking_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Pet species distribution
        $speciesStats = Pet::select('species', DB::raw('COUNT(*) as count'))
            ->groupBy('species')
            ->orderByDesc('count')
            ->get();
        
        // Treatment trends (last 30 days)
        $dailyTreatments = Treatment::select(
            DB::raw('DATE(treatment_date) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('treatment_date', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Top collaborators by treatment count
        $topCollaborators = Treatment::select('users.name', DB::raw('COUNT(*) as treatment_count'))
            ->join('users', 'treatments.user_id', '=', 'users.id')
            ->where('treatments.treatment_date', '>=', now()->subMonths(3))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('treatment_count')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalCustomers',
            'totalPets',
            'totalCollaborators',
            'todayBookings',
            'pendingBookings',
            'totalTreatments',
            'totalTags',
            'unassignedTags',
            'bookingStatusStats',
            'recentBookings',
            'recentTreatments',
            'monthlyBookings',
            'speciesStats',
            'dailyTreatments',
            'topCollaborators'
        ));
    }
}
