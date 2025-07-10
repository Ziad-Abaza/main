<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Http\Resources\NewsResource;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('author', 'media')->orderByDesc('published_at')->get();

        return NewsResource::collection($news);
    }

    public function show(News $news)
    {
        $news->load('author', 'media');
        return new NewsResource($news);
    }
}
