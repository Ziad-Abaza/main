@extends('dashboard.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Scan Student Code</h3>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('console.students.scan') }}" id="scan-form">
                        @csrf
                        <div class="mb-3">
                            <label for="code" class="form-label">Enter Student Code</label>
                            <input type="text" name="code" id="code" class="form-control" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <div class="my-4">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            You can scan a QR code or manually enter the code above.
                        </div>
                        <div id="reader"></div>
                        <div id="camera-error" class="camera-error" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Camera access denied!</strong><br>
                            Please allow camera access in your browser and refresh the page.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
        document.getElementById('code').value = decodedText;
        document.getElementById('scan-form').submit();
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
<style>
#reader {
    width: 100%;
    max-width: 320px;
    height: 320px;
    margin: 0 auto;
    border: 2px solid #4CAF50;
    border-radius: 8px;
    background: #000;
}
</style>
@endpush
