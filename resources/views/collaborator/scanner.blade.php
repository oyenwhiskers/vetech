@extends('layouts.vetech')

@section('title', 'QR Scanner')
@section('header', 'Scan Pet Tag')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <div class="text-center mb-4 sm:mb-6">
            <i class="fas fa-qrcode text-5xl sm:text-6xl text-blue-600 mb-3 sm:mb-4"></i>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">Scan Pet Tag</h3>
            <p class="text-sm sm:text-base text-gray-600">Scan QR code or enter tag number to view medical records</p>
        </div>

        <!-- Camera Scanner -->
        <div class="bg-gray-50 rounded-lg p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-semibold text-gray-700">Camera Scanner</h4>
                <span class="text-xs text-gray-500">
                    <i class="fas fa-mobile-alt mr-1"></i>Works on mobile devices
                </span>
            </div>
            
            <div class="text-center mb-3">
                <button 
                    id="startScanBtn"
                    onclick="startCamera()"
                    class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-800 transition font-medium shadow-sm">
                    <i class="fas fa-camera mr-2"></i>Open Camera Scanner
                </button>
            </div>
            
            <div id="cameraContainer" class="hidden">
                <div class="relative bg-black rounded-lg overflow-hidden mb-3" style="max-width: 100%; aspect-ratio: 4/3;">
                    <div id="qrVideo" class="w-full h-full"></div>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="border-4 border-blue-600 rounded-lg shadow-lg" style="width: 250px; height: 250px;">
                            <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-white"></div>
                            <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-white"></div>
                            <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-white"></div>
                            <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-white"></div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center gap-2">
                    <button 
                        onclick="stopCamera()"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition text-sm font-medium">
                        <i class="fas fa-times mr-2"></i>Stop Camera
                    </button>
                </div>
                <div id="scanStatus" class="mt-2 text-sm text-center text-gray-600 font-medium"></div>
            </div>
        </div>

        <!-- Manual Entry -->
        <div class="bg-gray-50 rounded-lg p-4 sm:p-6 mb-4 sm:mb-6">
            <label for="tagCode" class="block text-sm font-medium text-gray-700 mb-2">
                Or enter tag number manually:
            </label>
            <form id="scanForm" class="flex flex-col sm:flex-row gap-2">
                <input 
                    type="text" 
                    id="tagCode" 
                    name="tagCode"
                    placeholder="e.g., 1010"
                    class="flex-1 border-gray-300 focus:border-blue-600 focus:ring-blue-600 rounded-md shadow-sm uppercase text-base"
                    required
                />
                <button 
                    type="submit"
                    class="w-full sm:w-auto px-6 py-2.5 sm:py-2 bg-blue-600 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transition font-medium"
                >
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </form>
        </div>

        <div class="border-t pt-4 sm:pt-6">
            <h4 class="font-semibold text-gray-900 mb-3 text-sm sm:text-base">Instructions:</h4>
            <ol class="list-decimal list-inside space-y-2 text-gray-600 text-sm sm:text-base">
                <li>Click "Open Camera Scanner" to scan QR code with your device camera</li>
                <li>Or enter the tag number manually (e.g., 1010)</li>
                <li>View the pet's medical history and owner details</li>
                <li>Add new treatment records as needed</li>
            </ol>
        </div>

        <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row gap-3 sm:gap-0 sm:justify-between">
            <a href="{{ route('collaborator.treatments.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-center sm:text-left py-2 sm:py-0">
                <i class="fas fa-list mr-2"></i>View My Treatments
            </a>
            <a href="{{ route('collaborator.treatments.deleted-log') }}" class="text-gray-600 hover:text-gray-800 font-medium text-center sm:text-left py-2 sm:py-0">
                <i class="fas fa-trash mr-2"></i>Deleted Log
            </a>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
let html5QrCode = null;

function startCamera() {
    const cameraContainer = document.getElementById('cameraContainer');
    const startBtn = document.getElementById('startScanBtn');
    const statusEl = document.getElementById('scanStatus');
    
    cameraContainer.classList.remove('hidden');
    startBtn.classList.add('hidden');
    statusEl.textContent = 'Starting camera...';
    
    html5QrCode = new Html5Qrcode("qrVideo");
    
    const config = { 
        fps: 10,
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.333334
    };
    
    html5QrCode.start(
        { facingMode: "environment" },
        config,
        (decodedText, decodedResult) => {
            statusEl.textContent = 'QR Code detected! Redirecting...';
            stopCamera();
            
            // Extract tag code from URL or use directly
            let tagCode = decodedText;
            
            // If it's a full URL, extract the tag code from it
            if (decodedText.includes('/')) {
                const parts = decodedText.split('/');
                tagCode = parts[parts.length - 1];
            }
            
            // Navigate to scan result
            window.location.href = '{{ url("collaborator/scan") }}/' + tagCode;
        },
        (errorMessage) => {
            // Silent - scanning errors are normal
            statusEl.textContent = 'Scanning... Point camera at QR code';
        }
    ).catch((err) => {
        statusEl.textContent = 'Error: ' + err;
        console.error('Camera error:', err);
    });
}

function stopCamera() {
    if (html5QrCode) {
        html5QrCode.stop().then(() => {
            html5QrCode.clear();
            document.getElementById('cameraContainer').classList.add('hidden');
            document.getElementById('startScanBtn').classList.remove('hidden');
            document.getElementById('scanStatus').textContent = '';
        }).catch((err) => {
            console.error('Error stopping camera:', err);
        });
    }
}

// Manual form submission
document.getElementById('scanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const tagCode = document.getElementById('tagCode').value.trim().toUpperCase();
    if (tagCode) {
        window.location.href = '{{ url("collaborator/scan") }}/' + tagCode;
    }
});
</script>
@endsection
