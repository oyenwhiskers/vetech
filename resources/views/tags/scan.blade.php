<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Information - {{ $tag->tag_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js for charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
            }
            .container {
                padding: 0 !important;
            }
            .max-w-4xl {
                max-width: 100% !important;
                box-shadow: none !important;
            }
            /* Hide browser's default print headers and footers */
            @page {
                margin: 0.5cm;
            }
            /* Prevent page breaks inside important sections */
            .pet-info-section,
            .treatment-card,
            .vitals-history-section {
                page-break-inside: avoid;
                break-inside: avoid;
            }
            /* Add page break before treatment history if needed */
            .treatment-history-section {
                page-break-before: auto;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <div class="mb-8">
                <div class="text-center mb-4">
                    <h1 class="text-3xl font-bold text-blue-900">VETech - DVS Sandakan Sabah</h1>
                    <p class="text-gray-600">Pet Information & Treatment History</p>
                </div>
                <div class="flex justify-end">
                    <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-200 no-print">
                        <i class="fas fa-print mr-2"></i>Print
                    </button>
                </div>
            </div>

            <!-- Pet Info -->
            <div class="border-b pb-6 mb-6 pet-info-section">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-semibold">{{ $tag->pet->name }}</h2>
                        <p class="text-gray-600">{{ $tag->pet->species }} - {{ $tag->pet->breed }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Tag Code</p>
                        <p class="font-mono font-semibold">{{ $tag->tag_code }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Owner</p>
                        <p class="font-semibold">{{ $tag->pet->customer->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Gender</p>
                        <p>{{ ucfirst($tag->pet->gender) }}</p>
                    </div>
                    @if($tag->pet->age)
                    <div>
                        <p class="text-sm text-gray-500">Age</p>
                        <p>{{ $tag->pet->age }} years</p>
                    </div>
                    @endif
                    @if($tag->pet->weight)
                    <div>
                        <p class="text-sm text-gray-500">Weight</p>
                        <p>{{ $tag->pet->weight }} kg</p>
                    </div>
                    @endif
                </div>

                <div class="mt-4">
                    <p class="text-sm text-gray-500">Contact Owner</p>
                    <p>{{ $tag->pet->customer->phone }}</p>
                </div>

                @if($tag->pet->special_notes)
                <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <p class="text-sm font-semibold text-yellow-800">Special Notes:</p>
                    <p class="text-sm">{{ $tag->pet->special_notes }}</p>
                </div>
                @endif
            </div>

            <!-- Treatment History -->
            <div class="treatment-history-section">
                <h3 class="text-xl font-semibold mb-4">Treatment History ({{ $tag->pet->treatments->count() }})</h3>
                
                @if($tag->pet->treatments->count() > 0)
                    <div class="space-y-4">
                        @foreach($tag->pet->treatments as $treatment)
                            <div class="border rounded-lg p-4 bg-gray-50 treatment-card">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold">{{ $treatment->treatment_date->format('d M Y') }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $treatment->user->name }}
                                            @if($treatment->collaborator)
                                                - {{ $treatment->collaborator->clinic_name }}
                                            @else 
                                                - DVS
                                            @endif
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $treatment->treatment_location == 'government' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ ucfirst($treatment->treatment_location) }}
                                    </span>
                                </div>
                                @if($treatment->disease)
                                    <p class="text-sm mb-1"><strong>Disease:</strong> {{ $treatment->disease }}</p>
                                @endif
                                <p class="text-sm mb-1"><strong>Diagnosis:</strong> {{ $treatment->diagnosis }}</p>
                                <p class="text-sm mb-1"><strong>Treatment:</strong> {{ $treatment->treatment_given }}</p>
                                @if($treatment->medication)
                                    <p class="text-sm mb-1"><strong>Medication:</strong> {{ $treatment->medication }}</p>
                                @endif
                                @if($treatment->treated_by)
                                    <p class="text-sm mb-1"><strong>Treated By:</strong> {{ $treatment->treated_by }}</p>
                                @endif
                                <div class="grid grid-cols-2 gap-2 mt-2 pt-2 border-t border-gray-200">
                                    @if($treatment->weight)
                                        <p class="text-sm"><strong>Weight:</strong> {{ number_format($treatment->weight, 2) }} kg</p>
                                    @endif
                                    @if($treatment->temperature)
                                        <p class="text-sm"><strong>Temperature:</strong> {{ number_format($treatment->temperature, 2) }} °C</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No treatment records available</p>
                @endif
            </div>

            <!-- Vitals History -->
            @php
                $vitalsData = $tag->pet->treatments->filter(function($treatment) {
                    return !$treatment->trashed() && (!is_null($treatment->weight) || !is_null($treatment->temperature));
                })->sortBy('treatment_date');
            @endphp
            
            @if($vitalsData->count() > 0)
            <div class="mt-8 vitals-history-section">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold flex items-center gap-2">
                        <i class="fas fa-heartbeat text-red-600"></i> Vitals History
                    </h3>
                    <button onclick="document.getElementById('vitalsChartModal').classList.remove('hidden')" 
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 no-print">
                        <i class="fas fa-chart-line mr-2"></i>View Chart
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Weight Chart -->
                    @php
                        $weightData = $vitalsData->filter(function($t) { return !is_null($t->weight) && $t->weight !== ''; });
                    @endphp
                    @if($weightData->count() > 0)
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-weight text-blue-600"></i> Weight (kg)
                                </h4>
                                <span class="text-sm text-gray-600">{{ $weightData->count() }} records</span>
                            </div>
                            <div style="height: 150px; position: relative;">
                                <canvas id="weightMiniChart"></canvas>
                            </div>
                        </div>
                    @endif

                    <!-- Temperature Chart -->
                    @php
                        $tempData = $vitalsData->filter(function($t) { return !is_null($t->temperature) && $t->temperature !== ''; });
                    @endphp
                    @if($tempData->count() > 0)
                        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4 border border-red-200">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-temperature-high text-red-600"></i> Temperature (°C)
                                </h4>
                                <span class="text-sm text-gray-600">{{ $tempData->count() }} records</span>
                            </div>
                            <div style="height: 150px; position: relative;">
                                <canvas id="temperatureMiniChart"></canvas>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Vitals Chart Modal -->
            <div id="vitalsChartModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 no-print">
                <div class="w-full h-full flex items-center justify-center p-4 overflow-y-auto">
                    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl p-6 md:p-8 relative">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <span class="bg-green-600 text-white rounded-full flex items-center justify-center w-12 h-12 shadow-lg">
                                    <i class="fas fa-chart-line text-2xl"></i>
                                </span>
                                <h3 class="text-xl md:text-2xl font-bold text-blue-900">Vitals Chart</h3>
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

            <div class="mt-8 text-center text-sm text-gray-500 no-print">
                <p>For more information, please contact Department of Veterinary Services Sabah</p>
            </div>
        </div>
    </div>

    <script>
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
                            pointRadius: 3,
                            pointHoverRadius: 5
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
                                        size: 10
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 10
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
                            pointRadius: 3,
                            pointHoverRadius: 5
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
                                        size: 10
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 10
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
</body>
</html>
