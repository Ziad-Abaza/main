@extends('dashboard.layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">Add Blog Post</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('dashboard.blog.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Excerpt</label>
            <input type="text" name="excerpt" class="form-control" value="{{ old('excerpt') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="6" required>{{ old('content') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Author</label>
            <input type="text" name="author" class="form-control" value="{{ old('author') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Published At</label>
            <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at') }}">
        </div>
        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('dashboard.blog.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
