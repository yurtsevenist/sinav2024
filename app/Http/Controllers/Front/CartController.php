<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Sepeti görüntüle
    public function index()
    {
        $cart = $this->getCart();
        return view('front.pages.cart.index', compact('cart'));
    }

    // Sepete ürün ekle
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = max(1, intval($request->quantity));

        if ($product->stock_quantity < $quantity) {
            return response()->json([
                'error' => 'Yetersiz stok!'
            ], 422);
        }

        $cart = $this->getCart();
        
        // Ürün sepette var mı kontrol et
        $found = false;
        foreach ($cart->items as $item) {
            if ($item->product_id == $product->id) {
                $item->quantity += $quantity;
                $item->total = $item->quantity * $item->price;
                $found = true;
                break;
            }
        }

        // Ürün sepette yoksa ekle
        if (!$found) {
            $cart->items[] = (object)[
                'product_id' => $product->id,
                'product' => $product,
                'quantity' => $quantity,
                'price' => $product->price,
                'total' => $product->price * $quantity
            ];
        }

        $this->updateCartTotals($cart);
        $this->saveCart($cart);

        return response()->json([
            'message' => 'Ürün sepete eklendi',
            'cartCount' => $this->getCartCount()
        ]);
    }

    // Sepetteki ürün miktarını güncelle
    public function update(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = max(1, intval($request->quantity));

        if ($product->stock_quantity < $quantity) {
            return response()->json([
                'error' => 'Yetersiz stok!'
            ], 422);
        }

        $cart = $this->getCart();
        
        foreach ($cart->items as $item) {
            if ($item->product_id == $product->id) {
                $item->quantity = $quantity;
                $item->total = $quantity * $item->price;
                break;
            }
        }

        $this->updateCartTotals($cart);
        $this->saveCart($cart);

        return response()->json([
            'message' => 'Sepet güncellendi',
            'cartCount' => $this->getCartCount()
        ]);
    }

    // Sepetten ürün kaldır
    public function remove(Request $request)
    {
        $cart = $this->getCart();
        
        $cart->items = array_filter($cart->items, function($item) use ($request) {
            return $item->product_id != $request->product_id;
        });

        $this->updateCartTotals($cart);
        $this->saveCart($cart);

        return response()->json([
            'message' => 'Ürün sepetten kaldırıldı',
            'cartCount' => $this->getCartCount()
        ]);
    }

    // İndirim kuponu uygula
    public function applyCoupon(Request $request)
    {
        $cart = $this->getCart();
        
        // Burada kupon kontrolü ve indirimi yapılacak
        // Şimdilik sabit %10 indirim uygulayalım
        $cart->discount_amount = $cart->subtotal * 0.10;
        
        $this->updateCartTotals($cart);
        $this->saveCart($cart);

        return back()->with('success', 'İndirim kuponu uygulandı');
    }

    // Yardımcı metodlar
    private function getCart()
    {
        $cart = Session::get('cart');
        
        if (!$cart) {
            $cart = (object)[
                'items' => [],
                'subtotal' => 0,
                'shipping_cost' => 0,
                'discount_amount' => 0,
                'total' => 0
            ];
        }

        return $cart;
    }

    private function saveCart($cart)
    {
        Session::put('cart', $cart);
    }

    private function updateCartTotals($cart)
    {
        // Alt toplam
        $cart->subtotal = array_reduce($cart->items, function($carry, $item) {
            return $carry + $item->total;
        }, 0);

        // Kargo ücreti
        $cart->shipping_cost = $cart->subtotal >= 250 ? 0 : 29.90;

        // Genel toplam
        $cart->total = $cart->subtotal + $cart->shipping_cost - $cart->discount_amount;
    }

    private function getCartCount()
    {
        $cart = $this->getCart();
        return array_reduce($cart->items, function($carry, $item) {
            return $carry + $item->quantity;
        }, 0);
    }
} 