@extends('dashboard.layouts.app')
@section('title', 'Edit Student - Children Students')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-radius-lg">
                <div class="card-header bg-white d-flex align-items-center py-3">
                    <i class="material-symbols-rounded fs-4 text-primary me-2">edit</i>
                    <h5 class="mb-0">Edit Student Information</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('console.children-students.update', $childrenStudent) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $childrenStudent->user->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ old('email', $childrenStudent->user->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Student Code</label>
                            <input type="text" name="code" id="code" class="form-control"
                                value="{{ old('code', $childrenStudent->code) }}" readonly>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('console.children-students.index') }}"
                                class="btn btn-outline-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="material-symbols-rounded fs-6 me-1">save</i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
