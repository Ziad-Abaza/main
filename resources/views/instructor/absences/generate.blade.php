@extends('instructor.layouts.app')
@section('title', 'Generate QR Code')

@section('styles')
<style>
    .qr-code-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
        padding: 20px;
        border-radius: 8px;
        background-color: #f8f9fa;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .qr-code-container img {
        margin-top: 15px;
        border: 1px solid #ddd;
        padding: 10px;
        background-color: white;
        border-radius: 4px;
    }

    .student-select {
        width: 100%;
        max-width: 400px;
    }

    .qr-options {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 20px;
        width: 100%;
        max-width: 400px;
    }

    .qr-options .form-group {
        flex: 1;
        min-width: 150px;
    }

    .btn-group {
        margin-top: 15px;
        display: flex;
        gap: 10px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Generate QR Code</h6>
                    <div>
                        <a href="{{ route('dashboard.absences.index') }}" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-list me-2"></i>View Absences
                        </a>
                        <a href="{{ route('dashboard.absences.scan') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-qrcode me-2"></i>Scan QR Code
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Generate QR codes for students to be used for attendance tracking.
                            </div>

                            <form action="{{ route('dashboard.absences.generate-qr') }}" method="GET">
                                <!-- Student Select -->
                                <x-inputs.select name="id" label="Select Student"
                                    :options="$students->pluck('user.name', 'id')" placeholder="-- Select a student --"
                                    :selected="request('id')" required class="student-select" />

                                <!-- Size & Format Options -->
                                <div class="qr-options">
                                    <x-inputs.number name="size" label="Size (px)" min="100" max="500" step="50"
                                        :value="request('size', 200)" required />

                                    <x-inputs.select name="format" label="Format"
                                        :options="['png' => 'PNG', 'svg' => 'SVG']" :selected="request('format', 'png')"
                                        required />
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-center mt-4">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-sync me-2"></i>Generate QR Code
                                        </button>

                                        @if(request('id'))
                                        <a href="{{ route('dashboard.absences.download-qr', [
                                                'id' => request('id'),
                                                'size' => request('size', 200),
                                                'format' => request('format', 'png')
                                            ]) }}" class="btn btn-success">
                                            <i class="fas fa-download me-2"></i>Download QR Code
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </form>

                            <!-- Display QR Code -->
                            @if(request('id'))
                            <div class="qr-code-container mt-4">
                                <h5 class="mb-3">
                                    {{ $students->firstWhere('id', request('id'))->user->name ?? '' }}
                                </h5>
                                <div>
                                    {!! $qrCode ?? '' !!}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
