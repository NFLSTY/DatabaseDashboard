<?php
  
namespace App\Http\Controllers;
  
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tag;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('store', 'category')->latest()->paginate(20);
  
        return view('products.index', compact('products'));
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Product::create($request->all());
 
        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::findOrFail($id);
  
        return view('products.show', compact('products'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products = Product::findOrFail($id);
        $stores = Store::get()->all();
        $categories = Category::get()->all();
        $tags = Tag::get()->all();

        return view('products.edit', compact('products', 'stores', 'categories', 'tags'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $products = Product::findOrFail($id);
  
        $products->update($request->all());
  
        return redirect()->route('products.index')->with('success', 'product updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products = Product::findOrFail($id);
  
        $products->delete();
  
        return redirect()->route('products.index')->with('success', 'product deleted successfully');
    }
}