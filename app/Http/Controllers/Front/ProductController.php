<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tüm ürünleri listele
    public function index(Request $request)
    {
        $query = Product::with(['category', 'defaultImage'])
            ->where('status', true);

        // Kategori filtresi
        if ($request->has('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        // Fiyat filtresi
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Stok durumu filtresi
        if ($request->has('in_stock')) {
            $query->where('stock_quantity', '>', 0);
        }

        // Sıralama
        switch ($request->get('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('front.pages.products.index', compact('products', 'categories'));
    }

    // Ürün detayı
    public function show($slug)
    {
        $product = Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        // Benzer ürünler
        $similarProducts = Product::with(['category', 'defaultImage'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', true)
            ->take(4)
            ->get();

        return view('front.pages.products.show', compact('product', 'similarProducts'));
    }

    // Kategori ürünleri
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $products = Product::with(['category', 'defaultImage'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->paginate(12);

        return view('front.pages.products.category', compact('category', 'products'));
    }

    // Ürün arama
    public function search(Request $request)
    {
        $query = $request->get('q');

        $products = Product::with(['category', 'defaultImage'])
            ->where('status', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%");
            })
            ->paginate(12);

        return view('front.pages.products.search', compact('products', 'query'));
    }
} 