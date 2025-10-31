<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Information - {{ $tag->tag_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            .treatment-card {
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
                                            Dr. {{ $treatment->user->name }}
                                            @if($treatment->collaborator)
                                                - {{ $treatment->collaborator->clinic_name }}
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
                                    <p class="text-sm"><strong>Treated By:</strong> {{ $treatment->treated_by }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No treatment records available</p>
                @endif
            </div>

            <div class="mt-8 text-center text-sm text-gray-500 no-print">
                <p>For more information, please contact Department of Veterinary Services Sabah</p>
            </div>
        </div>
    </div>
</body>
</html>
