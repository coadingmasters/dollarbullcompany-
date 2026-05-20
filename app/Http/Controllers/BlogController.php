<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()
            ->latest('published_at')
            ->paginate(9);

        return view('blogs.index', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        if ($blog->status !== 'published') {
            abort(404);
        }

        $prev = Blog::published()
            ->where('published_at', '<', $blog->published_at)
            ->latest('published_at')
            ->first();

        $next = Blog::published()
            ->where('published_at', '>', $blog->published_at)
            ->oldest('published_at')
            ->first();

        return view('blogs.show', compact('blog', 'prev', 'next'));
    }
}
