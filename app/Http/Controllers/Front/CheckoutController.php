<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart');
        if (!$cart || empty($cart->items)) {
            return redirect()->route('cart.index')
                ->with('error', 'Sepetiniz boş!');
        }

        $addresses = auth()->user()->addresses;
        $paymentMethods = PaymentMethod::where('status', true)
            ->orderBy('order')
            ->get();

        return view('front.pages.checkout.index', compact('cart', 'addresses', 'paymentMethods'));
    }

    public function process(Request $request)
    {
        $cart = session('cart');
        if (!$cart || empty($cart->items)) {
            return back()->with('error', 'Sepetiniz boş!');
        }

        // Form validasyonu
        $request->validate([
            'shipping_address_id' => 'required|exists:addresses,id',
            'billing_address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|exists:payment_methods,code',
            'terms' => 'accepted'
        ]);

        // Sipariş oluştur
        $order = new Order();
        $order->user_id = auth()->id();
        $order->order_number = 'ORD-' . strtoupper(Str::random(8));
        $order->total_amount = $cart->total;
        $order->shipping_cost = $cart->shipping_cost;
        $order->discount_amount = $cart->discount_amount;
        $order->payment_status = 'pending';
        $order->order_status = 'pending';
        $order->shipping_address_id = $request->shipping_address_id;
        $order->billing_address_id = $request->billing_address_id;
        $order->notes = $request->notes;
        $order->save();

        // Sipariş ürünlerini ekle
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'total_price' => $item->total
            ]);

            // Stok güncelle
            $item->product->decreaseStock($item->quantity);
        }

        // Ödeme yöntemine göre işlem yap
        switch ($request->payment_method) {
            case 'credit_card':
                // Kredi kartı işlemleri
                // Burada ödeme entegrasyonu yapılacak
                break;

            case 'bank_transfer':
                // Havale bilgilerini göster
                return redirect()->route('checkout.bank-transfer', $order)
                    ->with('success', 'Siparişiniz alındı. Lütfen havale bilgilerini kullanarak ödeme yapın.');

            case 'cash_on_delivery':
                // Kapıda ödeme
                break;
        }

        // Sepeti temizle
        session()->forget('cart');

        return redirect()->route('orders.show', $order)
            ->with('success', 'Siparişiniz başarıyla oluşturuldu!');
    }

    public function bankTransfer(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $bankAccounts = BankAccount::where('status', true)
            ->orderBy('order')
            ->get();

        return view('front.pages.checkout.bank-transfer', compact('order', 'bankAccounts'));
    }
} 