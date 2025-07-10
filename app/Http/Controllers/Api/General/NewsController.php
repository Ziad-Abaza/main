<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Http\Resources\NewsResource;
use App\Services\CacheService;

class NewsController extends Controller
{
    protected $cacheService;
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    /**
     * Retrieve all news articles with caching.
     */
    public function index()
    {
        return $this->cacheService->remember('news_list', function () {
            $news = News::with('author', 'media')
                ->orderByDesc('published_at')
                ->get();
            return NewsResource::collection($news);
        });
    }

    /**
     * Retrieve a single news article with caching.
     */
    public function show(News $news)
    {
        $key = "news_{$news->id}";
        return $this->cacheService->remember($key, function () use ($news) {
            $news->load('author', 'media');
            return new NewsResource($news);
        });
    }
}
