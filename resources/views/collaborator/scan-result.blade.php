@extends('layouts.vetech')

@section('title', 'Scan Result - ' . $tag->tag_code)
@section('header', 'Pet Medical Record')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Pet & Owner Info -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4 gap-3">
            <div class="flex-1">
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $tag->pet->name }}</h3>
                <div class="text-sm sm:text-base text-gray-600 space-y-1 sm:space-y-0 mt-2">
                    <p>
                        <span class="font-medium">Tag:</span> {{ $tag->tag_code }}
                    </p>
                    <p>
                        <span class="font-medium">Species:</span> {{ ucfirst($tag->pet->species) }}
                        @if($tag->pet->breed)
                            <span class="sm:ml-4 block sm:inline"><span class="font-medium">Breed:</span> {{ $tag->pet->breed }}</span>
                        @endif
                    </p>
                </div>
            </div>
            <a href="{{ route('collaborator.treatments.create', $tag->pet) }}" 
               class="w-full sm:w-auto text-center px-4 py-2.5 sm:py-2 bg-blue-600 text-white rounded-md hover:bg-blue-800 transition font-medium">
                <i class="fas fa-plus mr-2"></i>Add Treatment
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 pt-4 border-t">
            <div class="col-span-1 flex justify-center items-center">
                <?php
                $placeholder = 'https://www.animalfocusvet.com/wp-content/uploads/sites/272/2023/01/Placeholder-23.png';
                $raw = $tag->pet->pet_image ?? null;
                if ($raw) {
                    $isHttp = preg_match('#^https?://#i', $raw) === 1;
                    $isStorageUrl = strpos($raw, '/storage/') === 0;
                    if ($isHttp || $isStorageUrl) {
                        $imgSrc = $raw;
                    } else {
                        $normalized = ltrim(preg_replace('#^/?storage/#', '', $raw), '/');
                        $imgSrc = asset('storage/' . $normalized);
                    }
                } else {
                    $imgSrc = $placeholder;
                }
                ?>
                <img src="{{ $imgSrc }}" alt="Pet Image" class="w-24 h-24 rounded-xl object-cover border" />
            </div>
            <div class="col-span-2">
                <h4 class="font-semibold text-gray-900 mb-2 text-sm sm:text-base">Pet Information</h4>
                <dl class="space-y-1 text-xs sm:text-sm">
                    <div><dt class="inline font-medium">Gender:</dt> <dd class="inline">{{ ucfirst($tag->pet->gender) }}</dd></div>
                    @if($tag->pet->age)
                        <div><dt class="inline font-medium">Age:</dt> <dd class="inline">{{ $tag->pet->age }} years</dd></div>
                    @endif
                    @if($tag->pet->weight)
                        <div><dt class="inline font-medium">Weight:</dt> <dd class="inline">{{ $tag->pet->weight }} kg</dd></div>
                    @endif
                    @if($tag->pet->color)
                        <div><dt class="inline font-medium">Color:</dt> <dd class="inline">{{ $tag->pet->color }}</dd></div>
                    @endif
                </dl>
            </div>
            <div class="col-span-1 flex justify-center items-center">
                <?php
                $placeholder = 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png?20150327203541';
                $raw = $tag->pet->customer->profile_image ?? null;
                if ($raw) {
                    $isHttp = preg_match('#^https?://#i', $raw) === 1;
                    $isStorageUrl = strpos($raw, '/storage/') === 0;
                    if ($isHttp || $isStorageUrl) {
                        $imgSrc = $raw;
                    } else {
                        $normalized = ltrim(preg_replace('#^/?storage/#', '', $raw), '/');
                        $imgSrc = asset('storage/' . $normalized);
                    }
                } else {
                    $imgSrc = $placeholder;
                }
                ?>
                <img src="{{ $imgSrc }}" alt="Customer Profile Image" class="w-24 h-24 rounded-xl object-cover border" />
            </div>
            <div class="col-span-2">
                <h4 class="font-semibold text-gray-900 mb-2 text-sm sm:text-base">Owner Information</h4>
                <dl class="space-y-1 text-xs sm:text-sm">
                    <div><dt class="inline font-medium">Name:</dt> <dd class="inline">{{ $tag->pet->customer->name }}</dd></div>
                    <div><dt class="inline font-medium">Phone:</dt> <dd class="inline">{{ $tag->pet->customer->phone }}</dd></div>
                    @if($tag->pet->customer->email)
                        <div><dt class="inline font-medium">Email:</dt> <dd class="inline break-all">{{ $tag->pet->customer->email }}</dd></div>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <!-- Vitals Section -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-heartbeat text-red-600"></i> Vitals History
            </h3>
            @php
                $vitalsData = $tag->pet->treatments->filter(function($treatment) {
                    return !$treatment->trashed() && (!is_null($treatment->weight) || !is_null($treatment->temperature));
                })->sortBy('treatment_date');
            @endphp
            @if($vitalsData->count() > 0)
                <button onclick="document.getElementById('vitalsChartModal').classList.remove('hidden')" 
                    class="text-sm sm:text-base px-3 py-2 sm:px-4 bg-green-600 hover:bg-green-700 text-white rounded-md transition font-medium flex items-center gap-2">
                    <i class="fas fa-chart-line"></i> <span class="hidden sm:inline">View Chart</span>
                </button>
            @endif
        </div>
        
        @if($vitalsData->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Weight Chart -->
                @php
                    $weightData = $vitalsData->filter(function($t) { return !is_null($t->weight); });
                @endphp
                @if($weightData->count() > 0)
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-3 sm:p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-sm sm:text-base font-semibold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-weight text-blue-600"></i> Weight (kg)
                            </h4>
                            <span class="text-xs text-gray-600">{{ $weightData->count() }} records</span>
                        </div>
                        <div style="height: 100px; position: relative;">
                            <canvas id="weightMiniChart"></canvas>
                        </div>
                    </div>
                @endif

                <!-- Temperature Chart -->
                @php
                    $tempData = $vitalsData->filter(function($t) { return !is_null($t->temperature); });
                @endphp
                @if($tempData->count() > 0)
                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-3 sm:p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-sm sm:text-base font-semibold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-temperature-high text-red-600"></i> Temperature (°C)
                            </h4>
                            <span class="text-xs text-gray-600">{{ $tempData->count() }} records</span>
                        </div>
                        <div style="height: 100px; position: relative;">
                            <canvas id="temperatureMiniChart"></canvas>
                        </div>
                    </div>
                @endif
            </div>

            @if($weightData->count() == 0 && $tempData->count() == 0)
                <div class="text-center py-6 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <i class="fas fa-heartbeat text-3xl text-gray-400 mb-2"></i>
                    <p class="text-gray-500 text-sm font-medium">No vitals data recorded yet</p>
                </div>
            @endif
        @else
            <div class="text-center py-6 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                <i class="fas fa-heartbeat text-3xl text-gray-400 mb-2"></i>
                <p class="text-gray-500 text-sm font-medium">No vitals data recorded yet</p>
            </div>
        @endif
    </div>

    <!-- Treatment History -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">Treatment History</h3>

        @if($tag->pet->treatments->count() > 0)
            <div class="space-y-3 sm:space-y-4">
                @foreach($tag->pet->treatments as $treatment)
                    <div class="border rounded-lg p-3 sm:p-4 {{ $treatment->trashed() ? 'bg-red-50 border-red-200' : 'bg-gray-50' }}">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-2 gap-2">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <span class="font-semibold text-gray-900 text-sm sm:text-base">
                                        {{ $treatment->treatment_date->format('M d, Y') }}
                                    </span>
                                    @if($treatment->trashed())
                                        <span class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                            <i class="fas fa-trash-alt mr-1"></i>DELETED
                                        </span>
                                    @endif
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                        {{ ucfirst($treatment->treatment_location) }}
                                    </span>
                                </div>
                                @if($treatment->disease)
                                    <p class="text-xs sm:text-sm text-gray-600"><span class="font-medium">Disease:</span> {{ $treatment->disease }}</p>
                                @endif
                                <p class="text-xs sm:text-sm text-gray-600"><span class="font-medium">Diagnosis:</span> {{ $treatment->diagnosis }}</p>
                            </div>
                            <div class="text-left sm:text-right text-xs sm:text-sm text-gray-600">
                                <p class="font-medium">{{ $treatment->treated_by ?? $treatment->user->name }}</p>
                                @if($treatment->collaborator)
                                    <p class="text-xs">{{ $treatment->collaborator->clinic_name }}</p>
                                @endif
                                @if($treatment->treated_by && $treatment->treated_by !== $treatment->user->name)
                                    <p class="text-xs text-gray-500">Record by: {{ $treatment->user->name }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-xs sm:text-sm text-gray-700 mt-2 space-y-1">
                            <p><span class="font-medium">Treatment:</span> {{ $treatment->treatment_given }}</p>
                            @if($treatment->treated_by)
                                <p><span class="font-medium">Treated By:</span> {{ $treatment->treated_by }}</p>
                            @endif
                            @if($treatment->medication)
                                <p><span class="font-medium">Medication:</span> {{ $treatment->medication }}</p>
                            @endif
                            @if($treatment->notes)
                                <p><span class="font-medium">Notes:</span> {{ $treatment->notes }}</p>
                            @endif
                        </div>

                        @if($treatment->trashed())
                            <div class="mt-2 pt-2 border-t border-red-200 text-xs text-red-600">
                                Deleted by {{ $treatment->deleter->name ?? 'Unknown' }} on {{ $treatment->deleted_at->format('M d, Y H:i') }}
                            </div>
                        @endif

                        <div class="mt-3 flex flex-wrap gap-2">
                            <button type="button"
                               data-url="{{ route('collaborator.treatments.show', $treatment) }}"
                               class="js-open-treatment-modal text-xs sm:text-sm text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-eye mr-1"></i>View Details
                            </button>
                            @if(!$treatment->trashed() && $treatment->canBeDeletedBy(Auth::user()))
                                <form method="POST" action="{{ route('collaborator.treatments.destroy', $treatment) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this treatment record? It will be moved to the deleted log.');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs sm:text-sm text-red-600 hover:text-red-800 font-medium">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
                            @elseif(!$treatment->trashed())
                                <span class="text-xs sm:text-sm text-gray-400">
                                    <i class="fas fa-lock mr-1"></i>View Only
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-clipboard-list text-3xl sm:text-4xl mb-3"></i>
                <p class="text-sm sm:text-base">No treatment records found.</p>
                <a href="{{ route('collaborator.treatments.create', $tag->pet) }}" 
                   class="inline-block mt-3 text-sm sm:text-base text-blue-600 hover:text-blue-800 font-medium">
                    Add the first treatment record
                </a>
            </div>
        @endif
    </div>

    <div class="mt-4 sm:mt-6 mb-4">
        <a href="{{ route('collaborator.scanner') }}" class="inline-block text-sm sm:text-base text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to Scanner
        </a>
    </div>

    <!-- Vitals Chart Modal -->
    <div id="vitalsChartModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="w-full h-full flex items-center justify-center p-4 overflow-y-auto">
            <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl p-4 sm:p-6 md:p-8 relative">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <span class="bg-green-600 text-white rounded-full flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 shadow-lg">
                            <i class="fas fa-chart-line text-lg sm:text-2xl"></i>
                        </span>
                        <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-[#334da1]">Vitals Chart</h3>
                    </div>
                    <button onclick="document.getElementById('vitalsChartModal').classList.add('hidden')" class="text-gray-600 hover:text-gray-800">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="mb-4" style="height: 400px; position: relative;">
                    <canvas id="vitalsDetailChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Treatment Details Modal -->
    <div id="treatmentDetailsModal" class="hidden fixed inset-0 z-50">
        <div class="w-full h-full bg-black bg-opacity-50 flex items-center justify-center p-4" role="dialog" aria-modal="true">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[85vh] overflow-y-auto">
                <div class="flex items-center justify-between px-5 py-3 border-b">
                    <div class="flex items-center gap-2">
                        <span class="bg-blue-600 text-white rounded-full flex items-center justify-center w-10 h-10">
                            <i class="fas fa-notes-medical"></i>
                        </span>
                        <h4 class="text-lg font-bold text-[#334da1]">Treatment Details</h4>
                    </div>
                    <button type="button" class="text-gray-600 hover:text-gray-800 js-close-treatment-modal" aria-label="Close">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="treatmentModalBody" class="p-5">
                    <div id="treatmentModalLoading" class="flex items-center justify-center py-10 text-gray-500">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('click', function(e) {
        var openBtn = e.target.closest('.js-open-treatment-modal');
        if (openBtn) {
            var modal = document.getElementById('treatmentDetailsModal');
            var body = document.getElementById('treatmentModalBody');
            var loading = document.getElementById('treatmentModalLoading');
            var url = openBtn.getAttribute('data-url');
            if (!modal || !body || !url) return;
            // Reset content and show loader
            body.innerHTML = '<div id="treatmentModalLoading" class="flex items-center justify-center py-10 text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Loading...</div>';
            modal.classList.remove('hidden');
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function(res){ return res.text(); })
                .then(function(html){ body.innerHTML = html; })
                .catch(function(){ body.innerHTML = '<div class="text-center py-10 text-red-600">Failed to load details. Please try again.</div>'; });
            return;
        }
        var closeBtn = e.target.closest('.js-close-treatment-modal');
        if (closeBtn) {
            var modal = document.getElementById('treatmentDetailsModal');
            if (modal) modal.classList.add('hidden');
            return;
        }
        var overlay = e.target.closest('#treatmentDetailsModal > div');
        if (!overlay && e.target.id === 'treatmentDetailsModal') {
            document.getElementById('treatmentDetailsModal').classList.add('hidden');
        }
    });

    // Vitals Charts
    document.addEventListener('DOMContentLoaded', function() {
        @php
            $vitalsData = $tag->pet->treatments->filter(function($treatment) {
                return !$treatment->trashed() && (!is_null($treatment->weight) || !is_null($treatment->temperature));
            })->sortBy('treatment_date')->values();
            
            $weightData = $vitalsData->filter(function($t) { return !is_null($t->weight) && $t->weight !== ''; })->values();
            $tempData = $vitalsData->filter(function($t) { return !is_null($t->temperature) && $t->temperature !== ''; })->values();
            
            $weightLabels = [];
            $weightValues = [];
            foreach($weightData as $t) {
                $weightLabels[] = $t->treatment_date->format('M d');
                $weightValues[] = (float)$t->weight;
            }
            
            $tempLabels = [];
            $tempValues = [];
            foreach($tempData as $t) {
                $tempLabels[] = $t->treatment_date->format('M d');
                $tempValues[] = (float)$t->temperature;
            }
            
            // Get unique dates
            $allDates = [];
            foreach($vitalsData as $t) {
                $dateStr = $t->treatment_date->format('Y-m-d');
                if (!in_array($dateStr, $allDates)) {
                    $allDates[] = $dateStr;
                }
            }
            sort($allDates);
            
            $allLabels = [];
            foreach($allDates as $date) {
                $allLabels[] = \Carbon\Carbon::parse($date)->format('M d, Y');
            }
            
            // Create arrays aligned with all dates
            $combinedWeights = [];
            $combinedTemps = [];
            foreach($allDates as $date) {
                $treatment = null;
                foreach($vitalsData as $t) {
                    if ($t->treatment_date->format('Y-m-d') === $date) {
                        $treatment = $t;
                        break;
                    }
                }
                $combinedWeights[] = $treatment && $treatment->weight !== null && $treatment->weight !== '' ? (float)$treatment->weight : null;
                $combinedTemps[] = $treatment && $treatment->temperature !== null && $treatment->temperature !== '' ? (float)$treatment->temperature : null;
            }
        @endphp

        // Mini Weight Chart
        @if($weightData->count() > 0 && count($weightLabels) > 0 && count($weightValues) > 0)
        const weightCtx = document.getElementById('weightMiniChart');
        if (weightCtx) {
            try {
                new Chart(weightCtx, {
                    type: 'line',
                    data: {
                        labels: @json($weightLabels),
                        datasets: [{
                            label: 'Weight (kg)',
                            data: @json($weightValues),
                        borderColor: 'rgb(37, 99, 235)',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 2,
                        pointHoverRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 1,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 9
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 9
                                }
                            }
                        }
                    }
                }
                });
            } catch(e) {
                console.error('Error creating weight chart:', e);
            }
        }
        @endif

        // Mini Temperature Chart
        @if($tempData->count() > 0 && count($tempLabels) > 0 && count($tempValues) > 0)
        const tempCtx = document.getElementById('temperatureMiniChart');
        if (tempCtx) {
            try {
                new Chart(tempCtx, {
                    type: 'line',
                    data: {
                        labels: @json($tempLabels),
                        datasets: [{
                            label: 'Temperature (°C)',
                            data: @json($tempValues),
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 2,
                        pointHoverRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 1,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 9
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 9
                                }
                            }
                        }
                    }
                }
                });
            } catch(e) {
                console.error('Error creating temperature chart:', e);
            }
        }
        @endif

        // Detailed Vitals Chart
        let vitalsDetailChart = null;
        const vitalsDetailCtx = document.getElementById('vitalsDetailChart');
        
        function initVitalsDetailChart() {
            if (!vitalsDetailCtx || vitalsDetailChart) return;
            
            try {
                vitalsDetailChart = new Chart(vitalsDetailCtx, {
                type: 'line',
                data: {
                    labels: @json($allLabels),
                    datasets: [
                        @if($weightData->count() > 0)
                        {
                            label: 'Weight (kg)',
                            data: @json($combinedWeights),
                            borderColor: 'rgb(37, 99, 235)',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            tension: 0.4,
                            fill: false,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            yAxisID: 'y'
                        },
                        @endif
                        @if($tempData->count() > 0)
                        {
                            label: 'Temperature (°C)',
                            data: @json($combinedTemps),
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4,
                            fill: false,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            yAxisID: 'y1'
                        }
                        @endif
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 2,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            enabled: true
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            type: 'linear',
                            display: @if($weightData->count() > 0) true @else false @endif,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Weight (kg)'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: @if($tempData->count() > 0) true @else false @endif,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Temperature (°C)'
                            },
                            grid: {
                                drawOnChartArea: false,
                            }
                        }
                    }
                }
                });
            } catch(e) {
                console.error('Error creating detailed vitals chart:', e);
            }
        }

        // Initialize chart when modal opens
        const vitalsModal = document.getElementById('vitalsChartModal');
        if (vitalsModal) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (!vitalsModal.classList.contains('hidden') && !vitalsDetailChart) {
                        setTimeout(initVitalsDetailChart, 100);
                    }
                });
            });
            observer.observe(vitalsModal, {
                attributes: true,
                attributeFilter: ['class']
            });
        }
    });
    </script>
</div>
@endsection
