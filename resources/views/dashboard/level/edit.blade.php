@extends('dashboard.layouts.app')
@section('title', 'Edit Level - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-radius-lg">
                <div class="card-header bg-white pb-0">
                    <h5 class="mb-0">Edit Level</h5>
                    <p class="text-sm text-muted mb-0">Update the level details below.</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('console.levels.update', $level) }}" method="POST">
                        @csrf
                        @method('POST')

                        <x-inputs.text name="name" label="Level Name" :value="$level->name" required />

                        <x-inputs.textarea name="description" label="Description" :value="$level->description" rows="3"
                            placeholder="Enter description..." />

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('console.levels.index') }}" class="btn btn-outline-secondary btn-sm px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark btn-sm px-4">
                                Update Level
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
