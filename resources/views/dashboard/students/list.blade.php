@extends('dashboard.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>All Students</h3>
            <a href="{{ route('console.students.scan') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-qrcode me-2"></i>Scan QR Code
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Code</th>
                        <th>Class Name</th>
                        <th>Level</th>
                        <th>Parent Name</th>
                        <th>Parent Phone</th>
                        <th>Phone</th>
                        <th>Age</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                            <td>{{ $student->user->name ?? '-' }}</td>
                            <td>{{ $student->user->email ?? '-' }}</td>
                            <td>{{ $student->code }}</td>
                            <td>{{ $student->class_name ?? '-' }}</td>
                            <td>{{ $student->level->name ?? '-' }}</td>
                            <td>{{ $student->meta['guardians_name'] ?? '-' }}</td>
                            <td>{{ $student->meta['guardians_phone'] ?? '-' }}</td>
                            <td>{{ $student->meta['phone'] ?? '-' }}</td>
                            <td>
                                @php
                                    $birthdate = $student->meta['age'] ?? null;
                                    $age = null;
                                    if ($birthdate && preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthdate)) {
                                        $age = \Carbon\Carbon::parse($birthdate)->age;
                                    }
                                @endphp
                                {{ $age ? $age . ' years' : '-' }}
                            </td>
                            <td>
                                <a href="{{ route('console.students.show', $student->id) }}" class="btn btn-sm btn-info" title="View">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
