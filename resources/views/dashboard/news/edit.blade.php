@extends('dashboard.layouts.app')
@section('title', 'Edit News - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card shadow-lg border-radius-lg">
                <!-- Card Header -->
                <div class="card-header bg-white pb-0">
                    <h5 class="mb-0">Edit News</h5>
                    <p class="text-sm text-muted mb-0">Update the details of this news article.</p>
                </div>

                <!-- Form -->
                <div class="card-body p-4">
                    <form action="{{ route('console.news.update', $news) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <!-- Title -->
                        <x-inputs.text name="title" label="News Title" :value="old('title', $news->title)"
                            placeholder="Enter news title" required />

                        <!-- Excerpt -->
                        <x-inputs.textarea name="excerpt" label="Excerpt" :value="old('excerpt', $news->excerpt)"
                            rows="3" placeholder="Short summary of the news..." />

                        <!-- Content -->
                        <x-inputs.textarea name="content" label="Content" :value="old('content', $news->content)"
                            rows="6" placeholder="Write your news content here..." required />

                        <!-- Category -->
                        <x-inputs.text name="category" label="Category" :value="old('category', $news->category)"
                            placeholder="e.g. Technology, Politics..." required />

                        <!-- Tags -->
                        <x-inputs.tags name="tags" label="Tags" :value="old('tags', $news->tags ?? [])" />

                        <!-- Published At -->
                        <x-inputs.date name="published_at" label="Publish Date & Time" :value="old(
                                'published_at',
                                optional($news->published_at)->format('Y-m-d\\TH:i')
                            )" :min="now()->subYear()->format('Y-m-d\\TH:i')" :max="now()->addYear()->format('Y-m-d\\TH:i')" required />
                        <!-- Existing Images -->
                        @if ($news->getImages()->first()['url'])
                        <div class="mb-3">
                            <label class="form-label">Current Images</label>
                            <div>
                                <img src="{{ $news->getFirstMediaUrl() }}" alt="News Image" width="150"
                                    class="rounded shadow-sm">
                            </div>
                        </div>
                        @endif

                        <!-- Upload New Images -->
                        <x-inputs.file name="images[]" label="Upload New Images" multiple accept="image/*" />

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('console.news.index') }}" class="btn btn-outline-secondary btn-sm px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark btn-sm px-4">
                                Update News
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
