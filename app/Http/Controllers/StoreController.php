<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('user')->withCount('products')->latest('id')->paginate(20);
        return view('stores.index', compact('stores'));
    }

    public function create()
    {
        // Get only users who do NOT have a store already.
        $users = User::whereDoesntHave('store')->orderBy('first_name')->get();
        
        return view('stores.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stores',
            'user_id' => 'required|exists:users,id|unique:stores,user_id',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        Store::create($request->all());
        return redirect()->route('stores.index')->with('success', 'Store created successfully.');
    }

    public function edit(Store $store)
    {
        // Get users who don't have a store, OR get the current owner of this store.
        // This ensures the current owner is always in the dropdown list for editing.
        $users = User::whereDoesntHave('store')
            ->orWhere('id', $store->user_id)
            ->orderBy('first_name')
            ->get();
            
        return view('stores.edit', compact('store', 'users'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name,' . $store->id,
            'user_id' => 'required|exists:users,id|unique:stores,user_id,' . $store->id,
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $store->update($request->all());
        return redirect()->route('stores.index')->with('success', 'Store updated successfully.');
    }

    public function destroy(Store $store)
    {
        if ($store->products()->count() > 0) {
            return back()->with('error', 'This store cannot be deleted because it has products.');
        }

        $store->delete();
        return redirect()->route('stores.index')->with('success', 'Store deleted successfully.');
    }
}
