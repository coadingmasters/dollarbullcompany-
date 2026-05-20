<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * List all blogs with search, filter, pagination
     */
    public function index(Request $request)
    {
        $query = Blog::latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $blogs = $query->paginate(10)->withQueryString();

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store new blog post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'slug'            => 'nullable|string|max:255|unique:blogs,slug',
            'excerpt'         => 'nullable|string|max:500',
            'body'            => 'required|string',
            'category'        => 'required|string|max:100',
            'author'          => 'nullable|string|max:100',
            'status'          => 'required|in:draft,published,scheduled',
            'published_at'    => 'nullable|date',
            'featured_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Auto-generate slug if not provided, ensure uniqueness
        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?? $validated['title']
        );

        // Set published_at automatically when publishing
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blogs', 'public');
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully.');
    }

    /**
     * Show single blog (preview)
     */
    public function show(Blog $blog)
    {
        return redirect()->route('admin.blogs.edit', $blog);
    }

    /**
     * Show edit form
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update existing blog post
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'slug'            => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'excerpt'         => 'nullable|string|max:500',
            'body'            => 'required|string',
            'category'        => 'required|string|max:100',
            'author'          => 'nullable|string|max:100',
            'status'          => 'required|in:draft,published,scheduled',
            'published_at'    => 'nullable|date',
            'featured_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Regenerate slug only if title changed and no custom slug given
        if (empty($request->slug)) {
            $validated['slug'] = $this->uniqueSlug($validated['title'], $blog->id);
        }

        // Auto set published_at when status switches to published
        if ($validated['status'] === 'published' && empty($validated['published_at']) && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        // Handle image upload — delete old one first
        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blogs', 'public');
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully.');
    }

    /**
     * Delete blog post
     */
    public function destroy(Blog $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted.');
    }

    /**
     * Generate a unique slug, ignoring current blog ID on update
     */
    private function uniqueSlug(string $value, int $ignoreId = null): string
    {
        $slug = Str::slug($value);
        $original = $slug;
        $count = 1;

        while (
            Blog::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}