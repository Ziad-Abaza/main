<?php
namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index() {
        return response()->json(Blog::orderByDesc('published_at')->get());
    }
    public function show(Blog $blog) {
        return response()->json($blog);
    }
}
