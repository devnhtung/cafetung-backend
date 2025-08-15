<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return response()->json($categories);
    }
    public function products($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return response()->json([
            'data' => $category->products,
            'message' => 'Products retrieved successfully',
        ]);
    }
}
