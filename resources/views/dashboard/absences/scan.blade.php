@extends('dashboard.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Scan Student Code for Absence</h3>
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
                    <form method="POST" action="{{ $recordRoute }}" id="scan-form">
                        @csrf
                        <div class="mb-3">
                            <label for="code" class="form-label">Enter Student Code</label>
                            <input type="text" name="child_code" id="code" class="form-control" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary">Record Absence</button>
                    </form>
                    <div class="my-4">
                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle me-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 .877-.252 1.02-.797l.088-.416c.066-.308.118-.438.288-.438.145 0 .176.105.145.438l-.088.416c-.194.897-.105 1.319-.808 1.319-.545 0-.877-.252-1.02-.797l-.088-.416c-.066-.308-.118-.438-.288-.438-.145 0-.176.105-.145.438l.088.416c.194.897.105 1.319.808 1.319.545 0 .877-.252 1.02-.797l.088-.416c.066-.308.118-.438.288-.438.145 0 .176.105.145.438l-.088.416c-.194.897-.105 1.319-.808 1.319-.545 0-.877-.252-1.02-.797l-.088-.416c-.066-.308-.118-.438-.288-.438-.145 0-.176.105-.145.438l.088.416c.194.897.105 1.319.808 1.319.545 0 .877-.252 1.02-.797l.088-.416c.066-.308.118-.438.288-.438.145 0 .176.105.145.438z"/>
                            </svg>
                            You can scan a QR code or manually enter the code above.
                        </div>
                        <div id="reader"></div>
                        <div id="camera-error" class="camera-error" style="display: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle me-2" viewBox="0 0 16 16">
                                <path d="M7.938 2.016a.13.13 0 0 1 .125 0l6.857 11.856c.06.104.01.228-.104.228H1.184a.13.13 0 0 1-.104-.228L7.938 2.016zm.82-1.447c-.58-1-2.017-1-2.598 0L.303 12.425C-.272 13.433.345 14.5 1.384 14.5h13.232c1.04 0 1.657-1.067 1.081-2.075L8.758.569zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1-2.002 0 1 1 0 0 1 2.002 0z"/>
                            </svg>
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
