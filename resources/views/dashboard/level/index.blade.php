@extends('dashboard.layouts.app')
@section('title', 'Levels - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12 col-12">
            <div class="card shadow-lg border-radius-lg">
                <!-- Header -->
                <div class="card-header bg-white pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Levels</h5>
                    <a href="{{ route('console.levels.create') }}" class="btn btn-dark btn-sm px-4">Add New Level</a>
                </div>

                <!-- Table -->
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($levels as $level)
                                <tr>
                                    <td>{{ $level->name }}</td>
                                    <td>{{ $level->description ?? '-' }}</td>
                                    <td>{{ $level->created_at->format('Y-m-d') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('console.levels.edit', $level) }}"
                                            class="btn btn-sm btn-outline-dark me-2" title="Edit">
                                            <i class="material-symbols-rounded fs-5">edit</i>
                                        </a>
                                        <form action="{{ route('console.levels.delete', $level) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure?');">
                                                <i class="material-symbols-rounded fs-5">delete</i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No levels found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="d-flex justify-content-center mt-4">
                        {{ $levels->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
