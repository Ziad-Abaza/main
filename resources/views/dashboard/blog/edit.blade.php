@extends('dashboard.layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">Edit Blog Post</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('dashboard.blog.update', $blog) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Excerpt</label>
            <input type="text" name="excerpt" class="form-control" value="{{ old('excerpt', $blog->excerpt) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="6" required>{{ old('content', $blog->content) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Author</label>
            <input type="text" name="author" class="form-control" value="{{ old('author', $blog->author) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Published At</label>
            <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('dashboard.blog.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
