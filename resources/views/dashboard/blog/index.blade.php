@extends('dashboard.layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">Blog Posts</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('dashboard.blog.create') }}" class="btn btn-primary mb-3">Add Blog Post</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Excerpt</th>
                <th>Author</th>
                <th>Published At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
            <tr>
                <td>{{ $blog->id }}</td>
                <td>{{ $blog->title }}</td>
                <td>{{ $blog->excerpt }}</td>
                <td>{{ $blog->author }}</td>
                <td>{{ $blog->published_at }}</td>
                <td>
                    <a href="{{ route('dashboard.blog.edit', $blog) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('dashboard.blog.destroy', $blog) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this blog post?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
