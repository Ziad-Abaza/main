@extends('instructor.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>All Students</h3>
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
                            <td>
                                <a href="{{ route('dashboard.students.show', $student->id) }}" class="btn btn-sm btn-info" title="View">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No students found.</td>
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
