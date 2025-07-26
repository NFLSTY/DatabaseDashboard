<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        $categoryCount = Category::count();
        $tagCount = Tag::count();
        $userCount = User::count();

        $recentProducts = Product::with('category')->latest()->take(5)->get();

        return view('dashboard', compact(
            'productCount',
            'categoryCount',
            'tagCount',
            'userCount',
            'recentProducts'
        ));
    }
}