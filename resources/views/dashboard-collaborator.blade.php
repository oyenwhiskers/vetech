@extends('layouts.vetech')

@section('title', 'Dashboard - VETech')
@section('header', 'My Dashboard')

@section('content')
<!-- Welcome Message -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-4 sm:p-6 mb-6 text-white">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold mb-1">Welcome back, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-white/80 text-sm sm:text-base">Here's your treatment activity summary</p>
        </div>
        <a href="{{ route('collaborator.scanner') }}" 
           class="w-full sm:w-auto text-center px-6 py-2.5 bg-white text-blue-600 rounded-md hover:bg-gray-100 transition font-medium shadow-md">
            <i class="fas fa-qrcode mr-2"></i>Scan Pet Tag
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
    <!-- Total Treatments -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                <i class="fas fa-clipboard-list text-white text-xl sm:text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-xs sm:text-sm text-gray-500">Total Treatments</p>
                <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $myTreatmentsTotal }}</p>
            </div>
        </div>
    </div>

    <!-- This Month -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                <i class="fas fa-calendar-alt text-white text-xl sm:text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-xs sm:text-sm text-gray-500">This Month</p>
                <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $myTreatmentsThisMonth }}</p>
            </div>
        </div>
    </div>

    <!-- Today -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-orange-500 rounded-md p-3">
                <i class="fas fa-calendar-day text-white text-xl sm:text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-xs sm:text-sm text-gray-500">Today</p>
                <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $myTreatmentsToday }}</p>
            </div>
        </div>
    </div>

    <!-- Deleted Records -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                <i class="fas fa-trash-alt text-white text-xl sm:text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-xs sm:text-sm text-gray-500">Deleted Records</p>
                <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $myDeletedTreatments }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
    <!-- Species Breakdown -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                <i class="fas fa-paw mr-2 text-blue-600"></i>Species Treated
            </h3>
        </div>
        <div class="p-4 sm:p-6">
            @if($speciesStats->count() > 0)
                <div class="space-y-3">
                    @foreach($speciesStats as $stat)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-2 h-2 rounded-full bg-blue-600 mr-3"></div>
                                <span class="text-sm font-medium text-gray-700">{{ ucfirst($stat->species) }}</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $stat->count }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($stat->count / $myTreatmentsTotal) * 100 }}%"></div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4 text-sm">No data available yet</p>
            @endif
        </div>
    </div>

    <!-- Location Breakdown -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Treatment Locations
            </h3>
        </div>
        <div class="p-4 sm:p-6">
            @if($locationStats->count() > 0)
                <div class="space-y-4">
                    @foreach($locationStats as $stat)
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full 
                                {{ $stat->treatment_location == 'clinic' ? 'bg-blue-100' : 'bg-green-100' }}">
                                <i class="fas {{ $stat->treatment_location == 'clinic' ? 'fa-hospital' : 'fa-home' }} 
                                    text-2xl {{ $stat->treatment_location == 'clinic' ? 'text-blue-600' : 'text-green-600' }}"></i>
                            </div>
                            <p class="mt-2 text-sm font-medium text-gray-700">{{ ucfirst($stat->treatment_location) }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stat->count }}</p>
                            <p class="text-xs text-gray-500">{{ number_format(($stat->count / $myTreatmentsTotal) * 100, 1) }}%</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4 text-sm">No data available yet</p>
            @endif
        </div>
    </div>

    <!-- Monthly Activity -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                <i class="fas fa-chart-line mr-2 text-blue-600"></i>6-Month Activity
            </h3>
        </div>
        <div class="p-4 sm:p-6">
            @if($monthlyTreatments->count() > 0)
                <div class="space-y-3">
                    @php
                        $maxCount = $monthlyTreatments->max('count');
                    @endphp
                    @foreach($monthlyTreatments as $month)
                        <div>
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>{{ date('M Y', strtotime($month->month . '-01')) }}</span>
                                <span class="font-bold">{{ $month->count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                     style="width: {{ $maxCount > 0 ? ($month->count / $maxCount) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4 text-sm">No activity data yet</p>
            @endif
        </div>
    </div>
</div>

<!-- Recent Treatments -->
<div class="bg-white rounded-lg shadow">
    <div class="px-4 sm:px-6 py-3 sm:py-4 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h3 class="text-base sm:text-lg font-semibold text-gray-900">
            <i class="fas fa-history mr-2 text-blue-600"></i>My Recent Treatments
        </h3>
        <a href="{{ route('collaborator.treatments.index') }}" 
           class="text-sm text-blue-600 hover:text-blue-800 font-medium">
            View All →
        </a>
    </div>
    <div class="p-4 sm:p-6">
        @if($myRecentTreatments->count() > 0)
            <!-- Mobile Card View -->
            <div class="block sm:hidden space-y-3">
                @foreach($myRecentTreatments as $treatment)
                    <div class="border rounded-lg p-3 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $treatment->pet->name }}</p>
                                <p class="text-xs text-gray-500">{{ $treatment->pet->customer->name }}</p>
                            </div>
                            <span class="text-xs text-gray-500">{{ $treatment->treatment_date->format('M d, Y') }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($treatment->diagnosis, 60) }}</p>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($treatment->treatment_location) }}
                            </span>
                            @if($treatment->disease)
                                <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                                    {{ $treatment->disease }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop Table View -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diagnosis</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($myRecentTreatments as $treatment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900 whitespace-nowrap">
                                    {{ $treatment->treatment_date->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $treatment->pet->name }}</div>
                                    <div class="text-xs text-gray-500">{{ ucfirst($treatment->pet->species) }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $treatment->pet->customer->name }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @if($treatment->disease)
                                        <span class="font-medium">{{ $treatment->disease }}</span><br>
                                    @endif
                                    {{ Str::limit($treatment->diagnosis, 50) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $treatment->treatment_location == 'clinic' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($treatment->treatment_location) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 sm:py-12">
                <i class="fas fa-clipboard-list text-4xl sm:text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-4 text-sm sm:text-base">No treatment records yet</p>
                <a href="{{ route('collaborator.scanner') }}" 
                   class="inline-block px-6 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-800 transition font-medium">
                    <i class="fas fa-qrcode mr-2"></i>Scan Your First Pet Tag
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
    <a href="{{ route('collaborator.scanner') }}" 
       class="flex items-center p-4 bg-white rounded-lg shadow hover:shadow-md transition">
        <div class="flex-shrink-0 w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-qrcode text-white text-xl"></i>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-900">Scan Pet Tag</p>
            <p class="text-xs text-gray-500">Start new treatment</p>
        </div>
    </a>

    <a href="{{ route('collaborator.treatments.index') }}" 
       class="flex items-center p-4 bg-white rounded-lg shadow hover:shadow-md transition">
        <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
            <i class="fas fa-list text-white text-xl"></i>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-900">My Treatments</p>
            <p class="text-xs text-gray-500">View all records</p>
        </div>
    </a>

    <a href="{{ route('collaborator.treatments.deleted-log') }}" 
       class="flex items-center p-4 bg-white rounded-lg shadow hover:shadow-md transition">
        <div class="flex-shrink-0 w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
            <i class="fas fa-trash-alt text-white text-xl"></i>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-900">Deleted Log</p>
            <p class="text-xs text-gray-500">Audit trail</p>
        </div>
    </a>
</div>
@endsection
