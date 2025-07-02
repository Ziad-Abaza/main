@extends('dashboard.layouts.app')
@section('title', 'Levels & Courses - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12 col-12">
            <div class="card shadow-lg border-radius-lg">
                <!-- Header -->
                <div class="card-header bg-white pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Levels & Courses</h5>
                    <a href="{{ route('console.level-courses.create') }}" class="btn btn-dark btn-sm px-4">Add New
                        Relation</a>
                </div>

                <!-- Table -->
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Level Name</th>
                                    <th>Courses Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($levels as $level)
                                <tr>
                                    <td>{{ $level->name }}</td>
                                    <td>{{ $level->courses->count() }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('console.level-courses.show', $level) }}"
                                            class="btn btn-sm btn-outline-dark me-2" title="View">
                                            <i class="material-symbols-rounded fs-5">visibility</i>
                                        </a>
                                        <a href="{{ route('console.level-courses.edit', $level) }}"
                                            class="btn btn-sm btn-outline-info me-2" title="Edit">
                                            <i class="material-symbols-rounded fs-5">edit</i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No levels found.</td>
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
