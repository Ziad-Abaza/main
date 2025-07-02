@extends('instructor.layouts.app')
@section('title', 'Scan QR Code')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Scan QR Code</h6>
                    <div>
                        <a href="{{ route('dashboard.absences.index') }}" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-list me-2"></i>View Absences
                        </a>
                        <a href="{{ route('dashboard.absences.generate') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-qrcode me-2"></i>Generate QR Code
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Position the QR code within the scanner frame. The system will automatically detect and process it.
                            </div>

                            <div class="scan-container">
                                <!-- Manual Input Form -->
                                <form action="{{ $recordRoute }}" method="POST" class="mb-4">
                                    @csrf
                                    <div class="input-group">
                                        <x-inputs.text name="child_code" placeholder="Enter the code from QR image" pattern="[a-zA-Z0-9\-]+"
                                            class="flex-grow-1" />
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check me-2"></i>Record Attendance
                                        </button>
                                    </div>
                                    <small class="text-muted mt-1 d-block">
                                        <i class="fas fa-info-circle me-1"></i>
                                        You can either scan the QR code or manually type the code shown below the QR image
                                    </small>
                                </form>

                                <!-- Scanned Code Display removed (debugging ended) -->

                                <!-- Camera Scanner -->
                                <div id="reader"></div>

                                <!-- Error Messages -->
                                <div id="camera-error" class="camera-error" style="display: none;">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Camera access denied!</strong><br>
                                    Please follow these steps:
                                    <ol class="mt-2 mb-0">
                                        <li>Click the camera/lock icon in your browser's address bar</li>
                                        <li>Select "Allow" for camera access</li>
                                        <li>Refresh this page</li>
                                    </ol>
                                    <div class="mt-3">
                                        <button onclick="requestCamera()" class="btn btn-primary btn-sm">
                                            <i class="fas fa-camera me-2"></i>Try Again
                                        </button>
                                    </div>
                                </div>

                                <!-- Results -->
                                @if(session('success'))
                                <div class="result-container result-success">
                                    @if(session('student'))
                                    <div class="student-info">
                                        <h5>{{ session('student.name') }}</h5>
                                        <p class="text-muted">Code: {{ session('student.code') }}</p>
                                        <p>
                                            <strong>Date:</strong> {{ session('absence.date') }}<br>
                                            <strong>Time:</strong> {{ session('absence.time') }}
                                        </p>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inline styles specific to this page -->
<style>
    .scan-container {
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        text-align: center;
    }
    #reader {
        width: 100%;
        max-width: 320px;
        height: 320px;
        margin: 0 auto;
        border: 2px solid #4CAF50;
        border-radius: 8px;
        background: #000;
    }
    .result-container {
        margin-top: 20px;
        padding: 20px;
        border-radius: 8px;
        background-color: #f8f9fa;
    }
    .result-success {
        border-left: 4px solid #4CAF50;
    }
    .result-error {
        border-left: 4px solid #F44336;
    }
    .camera-error {
        margin: 20px 0;
        padding: 15px;
        border-radius: 8px;
        background-color: #ffebee;
        border-left: 4px solid #F44336;
    }
    .student-info {
        margin: 15px 0;
    }
</style>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let html5QrCode = null;
    let scanned = false;
    const config = {
        fps: 20,
        qrbox: { width: 300, height: 300 },
        aspectRatio: 1.0
    };

    function onScanSuccess(decodedText) {
        if (scanned) return;
        scanned = true;
        const input = document.querySelector('input[name="child_code"]');
        if (input) {
            input.value = decodedText;
            input.form.submit();
        }
    }

    function onScanFailure(error) {
        // Optionally handle scan errors
    }

    function startScanner() {
        html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            { facingMode: "environment" },
            config,
            onScanSuccess,
            onScanFailure
        ).catch(err => {
            document.getElementById('camera-error').style.display = 'block';
        });
    }

    startScanner();
});
</script>
@endpush

