@extends('dashboard.layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">Add FAQ</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('dashboard.faq.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Question</label>
            <input type="text" name="question" class="form-control" value="{{ old('question') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Answer</label>
            <textarea name="answer" class="form-control" rows="4" required>{{ old('answer') }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('dashboard.faq.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
