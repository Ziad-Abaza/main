<!-- resources/views/dashboard/news/index.blade.php -->
@extends('dashboard.layouts.app')
@section('title', 'News Management')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-2 text-dark">News Management</h3>
                <a href="{{ route('console.news.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New News
                </a>
            </div>
            <p class="text-muted">Manage news articles for your platform.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow-lg rounded-4 p-4">
                <h5 class="mb-3">News Articles</h5>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Author</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Category</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($news as $article)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        @if($article->getImages()->isNotEmpty())
                                        <div>
                                            <img src="{{ $article->getImages()->first()['url'] }}"
                                                class="avatar avatar-sm me-3" alt="image">
                                        </div>
                                        @endif
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ Str::limit($article->title, 50) }}</h6>
                                            <p class="text-xs text-muted mb-0">{{ Str::limit($article->excerpt, 80) }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $article->author->name ?? 'N/A' }}</p>
                                </td>
                                <td>
                                    <span class="badge bg-gradient-primary">{{ $article->category }}</span>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $article->published_at ?
                                        $article->published_at->format('Y-m-d') : 'N/A' }}</p>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('console.news.edit', $article) }}"
                                        class="btn btn-sm btn-info me-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('console.news.destroy', $article) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this news article?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-newspaper fa-2x mb-3"></i>
                                    <p class="mb-0">No news articles found</p>
                                    <p class="text-xs mt-1">Click "Add New News" to create your first article</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($news instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-4">
                    {{ $news->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("News Dashboard Page Loaded");
    });
</script>
@endpush
