<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('super.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = \App\Models\BlogCategory::where('status', true)->get();
        return view('super.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'author' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['status'] = $request->has('status');
        $validated['author'] = $request->author ?: 'Admin';

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/blogs'), $imageName);
            $validated['image'] = 'uploads/blogs/' . $imageName;
        }

        Blog::create($validated);

        return redirect()->route('super.blogs.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = \App\Models\BlogCategory::where('status', true)->get();
        return view('super.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'author' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['status'] = $request->has('status');
        $validated['author'] = $request->author ?: 'Admin';

        if ($request->hasFile('image')) {
            if ($blog->image && file_exists(public_path($blog->image))) {
                @unlink(public_path($blog->image));
            }
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/blogs'), $imageName);
            $validated['image'] = 'uploads/blogs/' . $imageName;
        }

        $blog->update($validated);

        return redirect()->route('super.blogs.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image && file_exists(public_path($blog->image))) {
            @unlink(public_path($blog->image));
        }
        $blog->delete();

        return redirect()->route('super.blogs.index')->with('success', 'Blog post deleted successfully.');
    }

    public function toggleStatus(Blog $blog)
    {
        $blog->update(['status' => !$blog->status]);
        $status = $blog->status ? 'Activated' : 'Deactivated';
        return redirect()->route('super.blogs.index')->with('success', "Blog post status {$status} successfully.");
    }
}
