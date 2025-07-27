<?php
  
namespace App\Http\Controllers;
  
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('store', 'category', 'tags')->latest()->paginate(20);
  
        return view('products.index', compact('products'));
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all necessary data for the form's dropdowns.
        $stores = Store::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('products.create', compact('stores', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'store_id' => 'required|exists:stores,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id', // Ensure every tag ID exists.
        ]);

        // Automatically generate the slug.
        $validated['slug'] = Str::slug($validated['name']);

        // Create the product.
        $product = Product::create($validated);

        // If tags were selected, attach them to the new product.
        if (!empty($validated['tags'])) {
            $product->tags()->attach($validated['tags']);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
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
    public function update(Request $request, Product $product)
    {
        // Validate the request.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'store_id' => 'required|exists:stores,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);
        
        // Update the slug if the name has changed.
        $validated['slug'] = Str::slug($validated['name']);

        // Update the product's main attributes.
        $product->update($validated);

        // Sync the tags. This will add/remove tags as needed.
        $product->tags()->sync($request->tags);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
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