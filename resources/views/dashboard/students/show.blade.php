@extends('dashboard.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Student Details</h3>
            <a href="{{ route('console.students.show', $student->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-calendar-times me-2"></i>View Absences
            </a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    @if($student->image)
                        <img src="{{ asset($student->image) }}" alt="Student Image" class="img-fluid rounded">
                    @else
                        <img src="{{ asset('public/assets/image/default-avatar.png') }}" alt="No Image" class="img-fluid rounded">
                    @endif
                </div>
                <div class="col-md-9">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td>{{ $student->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $student->user->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Code</th>
                            <td>{{ $student->code }}</td>
                        </tr>
                        <tr>
                            <th>Class Name</th>
                            <td>{{ $student->class_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td>{{ $student->level->name ?? '-' }}</td>
                        </tr>
                        @if(is_array($student->meta) && count($student->meta))
                            @foreach($student->meta as $key => $value)
                                <tr>
                                    <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                                    <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                                </tr>
                            @endforeach
                        @endif
                        <tr>
                            <th>Created At</th>
                            <td>{{ $student->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $student->updated_at }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
