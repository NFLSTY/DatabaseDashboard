<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        $categoryCount = Category::count();
        $tagCount = Tag::count();
        $userCount = User::count();
        $storeCount = Store::count(); // Added store count

        $recentProducts = Product::with('category')->latest()->take(5)->get();

        return view('dashboard', compact(
            'productCount',
            'categoryCount',
            'tagCount',
            'userCount',
            'storeCount',
            'recentProducts'
        ));
    }
}
