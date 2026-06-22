<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::latest()->get();
        return view('super.blog-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('super.blog-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug',
        ]);

        $validated['status'] = $request->has('status');

        // Remove slug if empty so model auto-generates it
        if (empty($validated['slug'])) {
            unset($validated['slug']);
        }

        BlogCategory::create($validated);

        return redirect()->route('super.blog-categories.index')->with('success', 'Blog category created successfully.');
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('super.blog-categories.edit', compact('blogCategory'));
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name,' . $blogCategory->id,
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug,' . $blogCategory->id,
        ]);

        $validated['status'] = $request->has('status');

        // If slug is provided, set it directly; if empty, let model auto-generate
        if (!empty($validated['slug'])) {
            $blogCategory->slug = $validated['slug'];
        } else {
            unset($validated['slug']);
        }

        $blogCategory->update($validated);

        return redirect()->route('super.blog-categories.index')->with('success', 'Blog category updated successfully.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        // Set related blogs category to null or delete them depending on design. Since we set set null in migration, it is automatic.
        $blogCategory->delete();

        return redirect()->route('super.blog-categories.index')->with('success', 'Blog category deleted successfully.');
    }

    public function toggleStatus(BlogCategory $category)
    {
        // Handle toggle parameter named {category} explicitly from patch route
        $category->update(['status' => !$category->status]);
        $status = $category->status ? 'Activated' : 'Deactivated';
        return redirect()->route('super.blog-categories.index')->with('success', "Blog category status {$status} successfully.");
    }
}
