<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage_blog']);
    }

    public function index()
    {
        $news = News::with('author')->orderByDesc('published_at')->paginate(10);
        return view('dashboard.news.index', compact('news'));
    }

    public function create()
    {
        return view('dashboard.news.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ])->validate();

        $validated['news_id'] = (string) Str::uuid();
        $validated['author_id'] = Auth::user()->user_id;

        $news = News::create($validated);

        if ($request->hasFile('images')) {
            $news->setImages($request->file('images'));
        }

        return redirect()->route('dashboard.news.index')->with('success', 'News created successfully');
    }

    public function show(News $news)
    {
        return view('dashboard.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('dashboard.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ])->validate();

        $news->update($validated);

        if ($request->hasFile('images')) {
            $news->setImages($request->file('images'));
        }

        return redirect()->route('dashboard.news.index')->with('success', 'News updated successfully');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('dashboard.news.index')->with('success', 'News deleted successfully');
    }
}
