@extends('dashboard.layouts.app')
@section('title', 'Create News - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card shadow-lg border-radius-lg">
                <!-- Card Header -->
                <div class="card-header bg-white pb-0">
                    <h5 class="mb-0">Create New News</h5>
                    <p class="text-sm text-muted mb-0">Fill in the details to create a new news article.</p>
                </div>

                <!-- Form -->
                <div class="card-body p-4">
                    <form action="{{ route('console.news.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <x-inputs.text name="title" label="News Title" :value="old('title')"
                            placeholder="Enter news title" required />

                        <!-- Excerpt -->
                        <x-inputs.textarea name="excerpt" label="Excerpt" :value="old('excerpt')" rows="3"
                            placeholder="Short summary of the news..." />

                        <!-- Content -->
                        <x-inputs.textarea name="content" label="Content" :value="old('content')" rows="6"
                            placeholder="Write your news content here..." required />

                        <!-- Category -->
                        <x-inputs.text name="category" label="Category" :value="old('category')"
                            placeholder="e.g. Technology, Politics..." required />

                        <!-- Tags -->
                        <x-inputs.tags name="tags" label="Tags" :value="old('tags')" placeholder="Enter tag and press +" />

                        <!-- Published At -->
                        <x-inputs.date name="published_at" label="Published Date" :value="old('published_at')" />

                        <!-- Images -->
                        <x-inputs.file name="images[]" label="News Images" multiple accept="image/*" />

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('console.news.index') }}" class="btn btn-outline-secondary btn-sm px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark btn-sm px-4">
                                Create News
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
