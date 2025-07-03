@extends('dashboard.layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">FAQs</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('dashboard.faq.create') }}" class="btn btn-primary mb-3">Add FAQ</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faqs as $faq)
            <tr>
                <td>{{ $faq->id }}</td>
                <td>{{ $faq->question }}</td>
                <td>{{ $faq->answer }}</td>
                <td>
                    <a href="{{ route('dashboard.faq.edit', $faq) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('dashboard.faq.destroy', $faq) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this FAQ?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
