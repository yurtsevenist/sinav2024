@extends('front.layouts.app')

@section('title', $product->name)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
<style>
    .swiper {
        width: 100%;
        height: 400px;
    }
    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .thumbnail-swiper {
        height: 100px;
        margin-top: 10px;
    }
    .thumbnail-swiper .swiper-slide {
        opacity: 0.4;
        cursor: pointer;
    }
    .thumbnail-swiper .swiper-slide-thumb-active {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Anasayfa</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('category.show', $product->category->slug) }}">
                    {{ $product->category->name }}
                </a>
            </li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Ürün Görselleri -->
        <div class="col-md-6">
            <!-- Ana Slider -->
            <div class="swiper main-swiper">
                <div class="swiper-wrapper">
                    @foreach($product->images as $image)
                        <div class="swiper-slide">
                            <img src="{{ asset($image->image_url) }}" 
                                 alt="{{ $product->name }}">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <!-- Thumbnail Slider -->
            <div class="swiper thumbnail-swiper">
                <div class="swiper-wrapper">
                    @foreach($product->images as $image)
                        <div class="swiper-slide">
                            <img src="{{ asset($image->image_url) }}" 
                                 alt="{{ $product->name }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Ürün Bilgileri -->
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            
            <!-- Fiyat ve Stok -->
            <div class="mb-4">
                <div class="h2 mb-0">{{ number_format($product->price, 2) }} TL</div>
                <div class="text-muted">
                    Stok Durumu: 
                    @if($product->inStock())
                        <span class="text-success">Stokta</span>
                    @else
                        <span class="text-danger">Stokta Yok</span>
                    @endif
                </div>
            </div>

            <!-- Sepete Ekle -->
            @if($product->inStock())
                <div class="mb-4">
                    <div class="input-group" style="width: 200px;">
                        <button class="btn btn-outline-secondary" 
                                type="button"
                                onclick="updateQuantity(-1)">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" 
                               class="form-control text-center" 
                               id="quantity" 
                               value="1" 
                               min="1" 
                               max="{{ $product->stock_quantity }}">
                        <button class="btn btn-outline-secondary" 
                                type="button"
                                onclick="updateQuantity(1)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <button onclick="addToCartWithQuantity({{ $product->id }})" 
                        class="btn btn-primary btn-lg mb-4">
                    <i class="fas fa-cart-plus me-2"></i>
                    Sepete Ekle
                </button>
            @else
                <button class="btn btn-secondary btn-lg mb-4" disabled>
                    Stokta Yok
                </button>
            @endif

            <!-- Ürün Açıklaması -->
            <div class="mb-4">
                <h5>Ürün Açıklaması</h5>
                <p>{{ $product->description }}</p>
            </div>

            <!-- Ürün Kodu -->
            <div class="text-muted">
                Ürün Kodu: {{ $product->sku }}
            </div>
        </div>
    </div>

    <!-- Benzer Ürünler -->
    @if($similarProducts->isNotEmpty())
        <div class="mt-5">
            <h3 class="mb-4">Benzer Ürünler</h3>
            <div class="row g-4">
                @foreach($similarProducts as $similarProduct)
                    <div class="col-md-3">
                        <div class="card h-100">
                            <img src="{{ asset($similarProduct->defaultImage?->image_url ?? 'images/no-image.jpg') }}" 
                                 class="card-img-top" 
                                 alt="{{ $similarProduct->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $similarProduct->name }}</h5>
                                <p class="card-text text-muted">
                                    {{ Str::limit($similarProduct->description, 100) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0">{{ number_format($similarProduct->price, 2) }} TL</span>
                                    @if($similarProduct->inStock())
                                        <button onclick="addToCart({{ $similarProduct->id }})" 
                                                class="btn btn-primary">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-secondary" disabled>
                                            Stokta Yok
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script>
    // Swiper Slider
    const mainSwiper = new Swiper('.main-swiper', {
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: {
                el: '.thumbnail-swiper',
                slidesPerView: 4,
                spaceBetween: 10,
            }
        }
    });

    // Miktar güncelleme
    function updateQuantity(change) {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value) + change;
        value = Math.max(1, Math.min(value, {{ $product->stock_quantity }}));
        input.value = value;
    }

    // Sepete ekleme
    function addToCartWithQuantity(productId) {
        const quantity = document.getElementById('quantity').value;
        addToCart(productId, quantity);
    }
</script>
@endpush 