@extends('dashboard.layouts.app')
@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Absences for {{ $student->user->name ?? '-' }}</h3>
            <a href="{{ route('console.students.show', $student->id) }}" class="btn btn-secondary btn-sm">Back to Details</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Recorded By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absences as $absence)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($absence->date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($absence->time)->format('h:i A') }}</td>
                            <td>{{ $absence->instructor->name ?? 'Unknown' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No absences found for this student.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
