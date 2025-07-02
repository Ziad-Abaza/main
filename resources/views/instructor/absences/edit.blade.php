@extends(Auth::user()->hasRole('admin') ? 'dashboard.layouts.app' : 'instructor.layouts.app')
@section('title', 'Edit Absence')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Edit Absence</h6>
                    <a href="{{ Auth::user()->hasRole('admin') ? route('console.absences.index') : route('dashboard.absences.index') }}" class="btn btn-sm btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('console.absences.update', $absence->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Student</label>
                            <input type="text" class="form-control" value="{{ $absence->childUniversity->user->name }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ $absence->date }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Time</label>
                            <input type="time" name="time" class="form-control" value="{{ $absence->time }}" required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
