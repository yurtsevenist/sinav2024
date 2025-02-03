@extends('front.layouts.app')

@section('title', 'Anasayfa')

@section('content')
<!-- Hero Section -->
<div class="container-fluid px-0">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/slider/1.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Yeni Sezon Ürünleri</h5>
                    <p>En yeni ürünlerimizi keşfedin</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/slider/2.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>İndirimli Ürünler</h5>
                    <p>Kaçırılmayacak fırsatlar</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Önceki</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Sonraki</span>
        </button>
    </div>
</div>

<!-- Öne Çıkan Kategoriler -->
<div class="container my-5">
    <h2 class="text-center mb-4">Popüler Kategoriler</h2>
    <div class="row g-4">
        @foreach($categories as $category)
        <div class="col-md-4">
            <div class="card h-100">
                @if($category->image)
                <img src="{{ asset($category->image) }}" class="card-img-top" alt="{{ $category->name }}">
                @endif
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $category->name }}</h5>
                    <p class="card-text text-muted">{{ $category->products_count }} ürün</p>
                    <a href="{{ route('products.category', $category->slug) }}" class="btn btn-outline-primary">
                        Ürünleri Gör
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Öne Çıkan Ürünler -->
<div class="container my-5">
    <h2 class="text-center mb-4">Öne Çıkan Ürünler</h2>
    <div class="row g-4">
        @foreach($featuredProducts as $product)
        <div class="col-md-3">
            <div class="card h-100">
                <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                </a>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                            {{ $product->name }}
                        </a>
                    </h5>
                    <p class="card-text">
                        @if($product->old_price > $product->price)
                        <small class="text-decoration-line-through text-muted">{{ number_format($product->old_price, 2) }} TL</small><br>
                        @endif
                        <strong class="text-primary">{{ number_format($product->price, 2) }} TL</strong>
                    </p>
                    <button onclick="addToCart({{ $product->id }})" class="btn btn-primary w-100">
                        Sepete Ekle
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Kampanyalar -->
<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body p-4">
                    <h3>Ücretsiz Kargo</h3>
                    <p class="mb-0">{{ $settings['free_shipping_min_amount'] }} TL ve üzeri alışverişlerinizde ücretsiz kargo!</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body p-4">
                    <h3>Güvenli Alışveriş</h3>
                    <p class="mb-0">256-bit SSL sertifikası ile güvenli alışveriş</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 