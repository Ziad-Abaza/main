@extends('instructor.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Student Details</h3>
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
                        <tr>
                            <th>Parent Name</th>
                            <td>{{ $student->meta['guardians_name'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Parent Phone</th>
                            <td>{{ $student->meta['guardians_phone'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $student->meta['phone'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Classroom</th>
                            <td>{{ $student->class_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Age</th>
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
                        </tr>
                        @if(request()->routeIs('console.students.show'))
                            @if(is_array($student->meta) && count($student->meta))
                                @foreach($student->meta as $key => $value)
                                    <tr>
                                        <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                                        <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                        {{-- <tr>
                            <th>Created At</th>
                            <td>{{ $student->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $student->updated_at }}</td>
                        </tr> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
