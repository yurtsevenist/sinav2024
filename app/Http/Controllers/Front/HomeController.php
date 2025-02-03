<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ana kategorileri ve ürün sayılarını al
        $categories = Category::withCount('products')
            ->whereNull('parent_id')
            ->where('status', true)
            ->orderBy('order')
            ->take(3)
            ->get();

        // Öne çıkan ürünleri al
        $featuredProducts = Product::with(['category', 'defaultImage'])
            ->where('status', true)
            ->where('featured', true)
            ->latest()
            ->take(8)
            ->get();

        return view('front.pages.home', compact('categories', 'featuredProducts'));
    }
} 