<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage_blog']);
    }

    /**
     * Display a listing of the news articles.
     */
    public function index()
    {
        $news = News::with('author')->orderByDesc('published_at')->paginate(10);
        return view('dashboard.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create()
    {
        return view('dashboard.news.create');
    }

    /**
     * Store a newly created news article in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'tags' => is_array($request->tags) ? $request->tags : explode(',', $request->tags)
        ]);
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'excerpt'       => 'nullable|string|max:500',
            'content'       => 'required|string',
            'category'      => 'required|string|max:100',
            'published_at'  => 'nullable|date',
            'tags'          => 'nullable|array',
            'images.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $news = new News($validated);
        $news->author_id = Auth::user()->user_id;
        $news->save();

        if ($request->hasFile('images')) {
            $news->setImages($request->file('images'));
        }

        return redirect()->route('console.news.index')->with('success', 'News created successfully.');
    }

    /**
     * Display the specified news article.
     */
    public function show(News $news)
    {
        return view('dashboard.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news article.
     */
    public function edit(News $news)
    {
        return view('dashboard.news.edit', compact('news'));
    }

    /**
     * Update the specified news article in storage.
     */
    public function update(Request $request, News $news)
    {
        $request->merge([
            'tags' => is_array($request->tags) ? $request->tags : explode(',', $request->tags)
        ]);
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'excerpt'       => 'nullable|string|max:500',
            'content'       => 'required|string',
            'category'      => 'required|string|max:100',
            'published_at'  => 'nullable|date',
            'tags'          => 'nullable|array',
            'images.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $news->update($validated);

        if ($request->hasFile('images')) {
            $news->setImages($request->file('images'));
        }

        return redirect()->route('console.news.index')->with('success', 'News updated successfully.');
    }

    /**
     * Remove the specified news article from storage.
     */
    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('console.news.index')->with('success', 'News deleted successfully.');
    }
}
