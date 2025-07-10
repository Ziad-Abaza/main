<?php
namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'can:manage_blog']);
    }
    
    public function index() {
        $blogs = Blog::orderByDesc('published_at')->get();
        return view('dashboard.blog.index', compact('blogs'));
    }
    public function create() {
        return view('dashboard.blog.create');
    }
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'content' => 'required|string',
            'author' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);
        Blog::create($request->only('title', 'excerpt', 'content', 'author', 'published_at'));
        return redirect()->route('dashboard.blog.index')->with('success', 'Blog post created successfully.');
    }
    public function edit(Blog $blog) {
        return view('dashboard.blog.edit', compact('blog'));
    }
    public function update(Request $request, Blog $blog) {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'content' => 'required|string',
            'author' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);
        $blog->update($request->only('title', 'excerpt', 'content', 'author', 'published_at'));
        return redirect()->route('dashboard.blog.index')->with('success', 'Blog post updated successfully.');
    }
    public function destroy(Blog $blog) {
        $blog->delete();
        return redirect()->route('dashboard.blog.index')->with('success', 'Blog post deleted successfully.');
    }
}
