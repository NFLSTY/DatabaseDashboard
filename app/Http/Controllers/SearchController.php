<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle global search across all models
     */
    public function index(Request $request)
    {
        $query = $request->input('search');
        
        if (empty($query)) {
            return redirect()->back()->with('error', 'Please enter a search term.');
        }

        // Search in products
        $products = Product::with('store', 'category', 'tags')
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhereHas('store', function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('category', function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->get();

        // Search in stores
        $stores = Store::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->latest()
            ->get();

        // Search in categories
        $categories = Category::where('name', 'LIKE', "%{$query}%")
            ->latest()
            ->get();

        // Search in tags
        $tags = Tag::where('name', 'LIKE', "%{$query}%")
            ->latest()
            ->get();

        $totalResults = $products->count() + $stores->count() + $categories->count() + $tags->count();

        return view('search.results', compact('query', 'products', 'stores', 'categories', 'tags', 'totalResults'));
    }
}
