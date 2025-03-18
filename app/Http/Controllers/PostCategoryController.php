<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostCategoryRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::withCount('posts')->get();
        return response()->json($categories);
    }


    public function store(StorePostCategoryRequest $request)
    {
        Gate::authorize('create', PostCategory::class);

        $request->validate([
            'name' => 'required|string|max:255|unique:post_categories,name',
            'description' => 'nullable|string',
        ]);

        $category = PostCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return response()->json($category, 201);
    }

    public function show(PostCategory $category)
    {
        return response()->json($category->load('posts'));
    }

    public function update(StorePostCategoryRequest $request, PostCategory $category)
    {
        Gate::authorize('update', $category);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return response()->json($category);
    }

    public function destroy(PostCategory $category)
    {
        Gate::authorize('delete', $category);

        // Kiểm tra xem danh mục có bài viết nào không
        if ($category->posts()->count() > 0) {
            return response()->json(['message' => 'Cannot delete category with associated posts'], 400);
        }

        $category->delete();
        return response()->json(null, 204);
    }
}
