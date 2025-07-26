<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        // Use withCount('products') to efficiently get the number of products
        // for each category. This adds a `products_count` attribute to each category object.
        $categories = Category::withCount('products')->latest()->paginate(20);
        
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:categories']);
        
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255|unique:categories,name,' . $category->id]);
        
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // We add a check here as a fallback, though the button should be disabled in the UI.
        if ($category->products()->count() > 0) {
            return back()->with('error', 'This category cannot be deleted because it is associated with products.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
