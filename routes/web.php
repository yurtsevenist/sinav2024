<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Ana Sayfa
Route::get('/', [HomeController::class, 'index'])->name('home');

// Statik Sayfalar
Route::get('/hakkimizda', [PageController::class, 'about'])->name('about');
Route::get('/iletisim', [PageController::class, 'contact'])->name('contact');
Route::post('/iletisim', [PageController::class, 'sendMessage'])->name('contact.send');
Route::get('/gizlilik-politikasi', [PageController::class, 'privacy'])->name('privacy');
Route::get('/kullanim-kosullari', [PageController::class, 'terms'])->name('terms');
Route::get('/sikca-sorulan-sorular', [PageController::class, 'faq'])->name('faq');
Route::get('/kargo-bilgileri', [PageController::class, 'shipping'])->name('shipping');
Route::get('/iade-ve-degisim', [PageController::class, 'return'])->name('return');
Route::get('/yardim', [PageController::class, 'help'])->name('help');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/orders', [ProfileController::class, 'orders'])->name('orders.index');
    Route::get('/addresses', [ProfileController::class, 'addresses'])->name('addresses.index');
});

// Ürünler
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/category/{slug}', [ProductController::class, 'category'])->name('category');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
});

// Sepet
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
});

// Ödeme
Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/bank-transfer/{order}', [CheckoutController::class, 'bankTransfer'])->name('bank-transfer');
});

Route::get('/shipping', function () {
    return view('front.pages.shipping');
})->name('shipping');
